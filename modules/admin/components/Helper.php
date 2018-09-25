<?php

namespace app\modules\admin\components;

use Yii;
use yii\web\User;
use yii\helpers\ArrayHelper;
use yii\caching\TagDependency;
use yii\web\Response;

/**
 * Description of Helper
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 2.3
 */
class Helper
{
    private static $_userRoutes = [];
    private static $_defaultRoutes;
    private static $_routes;
    private static $_groupId = [];
    private static $_groupRoles = [];

    public static function getRegisteredRoutes()
    {
        if (self::$_routes === null) {
            self::$_routes = [];
            $manager = Yii::$app->getAuthManager();
            foreach ($manager->getPermissions() as $item) {
                if ($item->name[0] === '/') {
                    self::$_routes[$item->name] = $item->name;
                }
            }
        }
        return self::$_routes;
    }

    /**
     * Get assigned routes by default roles
     * @return array
     */
    protected static function getDefaultRoutes()
    {
        if (self::$_defaultRoutes === null) {
            $manager = Yii::$app->getAuthManager();

            $roles = $manager->defaultRoles;
            
            $cache = Configs::cache();
            if ($cache && ($routes = $cache->get($roles)) != false) {
                self::$_defaultRoutes = $routes;

            } else {
                
                $permissions = self::$_defaultRoutes = [];
                $roles = self::$_groupRoles;
                foreach ($roles as $role) {
                    $permissions = array_merge($permissions, $manager->getPermissionsByRole($role));
                }

                foreach ($permissions as $item) {
                    if ($item->name[0] === '/') {
                        self::$_defaultRoutes[$item->name] = true;
                    }
                }
                if ($cache) {
                    $cache->set($roles, self::$_defaultRoutes, Configs::cacheDuration(), new TagDependency([
                        'tags' => Configs::CACHE_TAG
                    ]));
                }
            }
        }
        return self::$_defaultRoutes;
    }

    /**
     * Get assigned routes of user.
     * @param integer $userId
     * @return array
     */
    public static function getGroupId($userId)
    {
        $groupsId = [];
        $groupsRole = [];
        $command = (new \yii\db\Query())
            ->select(['group_id'])
            ->from('user_group')
            ->where(['user_id' => $userId])
            ->createCommand();
        self::$_groupId = $rows = $command->queryAll();
        foreach($rows as $r => $v)
        {
            array_push($groupsId,$v['group_id']);
        }
        $command = (new \yii\db\Query())
            ->select(['item_name'])
            ->from('auth_assignment')
            ->where(['user_id' => $groupsId])
            ->createCommand();
        $rows = $command->queryAll();
        foreach($rows as $r => $v)
        {
            array_push($groupsRole,$v['item_name']);
        }
        self::$_groupRoles = $groupsRole;
        
    }

    public static function getRoutesByUser($userId)
    {
        self::getGroupId($userId);
        
        if (!isset(self::$_userRoutes[$userId])) {
            $cache = Configs::cache();
            if ($cache && ($routes = $cache->get([__METHOD__, $userId])) != false) {
                 
                self::$_userRoutes[$userId] = $routes;
            } else {
                $routes = static::getDefaultRoutes();
                $manager = Yii::$app->getAuthManager();
                foreach ($manager->getPermissionsByUser($userId) as $item) {
                    if ($item->name[0] === '/') {
                        $routes[$item->name] = true;
                    }
                }
                self::$_userRoutes[$userId] = $routes;
                if ($cache) {
                    $cache->set([__METHOD__, $userId], $routes, Configs::cacheDuration(), new TagDependency([
                        'tags' => Configs::CACHE_TAG
                    ]));
                }
            }
        }
        return self::$_userRoutes[$userId];
    }

    /**
     * Check access route for user.
     * @param string|array $route
     * @param integer|User $user
     * @return boolean
     */
    public static function checkRoute($route, $params = [], $user = null)
    {

        $config = Configs::instance();
        $r = static::normalizeRoute($route);
        if ($config->onlyRegisteredRoute && !isset(static::getRegisteredRoutes()[$r])) {
            return true;
        }
        
        if ($user === null) {
            $user = Yii::$app->getUser();
        }
        $userId = $user instanceof User ? $user->getId() : $user;

        if ($config->strict) {
            if ($user->can($r, $params)) {
                return true;
            }
            while (($pos = strrpos($r, '/')) > 0) {
                $r = substr($r, 0, $pos);
                if ($user->can($r . '/*', $params)) {
                    return true;
                }
            }
            return $user->can('/*', $params);
        } else {
            $routes = static::getRoutesByUser($userId);
            if (isset($routes[$r])) {
                return true;
            }
            while (($pos = strrpos($r, '/')) > 0) {
                $r = substr($r, 0, $pos);
                if (isset($routes[$r . '/*'])) {
                    return true;
                }
            }
            return isset($routes['/*']);
        }
    }

    protected static function normalizeRoute($route)
    {
        if ($route === '') {
            return '/' . Yii::$app->controller->getRoute();
        } elseif (strncmp($route, '/', 1) === 0) {
            return $route;
        } elseif (strpos($route, '/') === false) {
            return '/' . Yii::$app->controller->getUniqueId() . '/' . $route;
        } elseif (($mid = Yii::$app->controller->module->getUniqueId()) !== '') {
            return '/' . $mid . '/' . $route;
        }
        return '/' . $route;
    }

    /**
     * Filter menu items
     * @param array $items
     * @param integer|User $user
     */
    public static function filter($items, $user = null)
    {
        if ($user === null) {
            $user = Yii::$app->getUser();
        }
        return static::filterRecursive($items, $user);
    }

    /**
     * Filter menu recursive
     * @param array $items
     * @param integer|User $user
     * @return array
     */
    protected static function filterRecursive($items, $user)
    {
        $result = [];
        foreach ($items as $i => $item) {
            $url = ArrayHelper::getValue($item, 'url', '#');
            $allow = is_array($url) ? static::checkRoute($url[0], array_slice($url, 1), $user) : true;

            if (isset($item['items']) && is_array($item['items'])) {
                $subItems = self::filterRecursive($item['items'], $user);
                if (count($subItems)) {
                    $allow = true;
                }
                $item['items'] = $subItems;
            }
            if ($allow) {
                $result[$i] = $item;
            }
        }
        return $result;
    }

    /**
     * Filter action column button. Use with [[yii\grid\GridView]]
     * ```php
     * 'columns' => [
     *     ...
     *     [
     *         'class' => 'yii\grid\ActionColumn',
     *         'template' => Helper::filterActionColumn(['view','update','activate'])
     *     ]
     * ],
     * ```
     * @param array|string $buttons
     * @param integer|User $user
     * @return string
     */
    public static function filterActionColumn($buttons = [], $user = null)
    {
        if (is_array($buttons)) {
            $result = [];
            foreach ($buttons as $button) {
                if (static::checkRoute($button, [], $user)) {
                    $result[] = "{{$button}}";
                }
            }
            return implode(' ', $result);
        }
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($user) {
            return static::checkRoute($matches[1], [], $user) ? "{{$matches[1]}}" : '';
        }, $buttons);
    }

    /**
     * Use to invalidate cache.
     */
    public static function invalidate()
    {
        if (Configs::cache() !== null) {
            TagDependency::invalidate(Configs::cache(), Configs::CACHE_TAG);
        }
    }

    public static function filterRoutes($routes = [], $action = true)
    {
        $res = $routes;

        if ($action)
            $res = self::filterAction($res);
        else
            $res = self::filterActionAllowed($res);

        $res = self::filterAllow($res);
        return $res;
    }

    public static function filterActionAllowed($routes)
    {
        $res = [];
        if (!empty($routes)) {
            foreach ($routes as $key => $value) {
                if (!empty($value) && $key == 'avaliable') {
                    foreach ($value as $k => $v) {
                        if (substr(trim($v), -1) !== '*') {
                            $res[$key][] = $v;
                        }
                    }
                } else {
                    $res[$key] = $value;
                }
            }
        }
        return $res;
    }

    public static function filterAction($routes)
    {
        $res = [];
        if (!empty($routes)) {
            foreach ($routes as $key => $value) {
                if (!empty($value)) {
                    foreach ($value as $k => $v) {
                        if (substr(trim($v), -1) !== '*') {
                            $res[$key][] = $v;
                        }
                    }
                } else {
                    $res[$key] = [];
                }
            }
        }
        return $res;
    }

    public static function filterAllow($routes)
    {
        $res = $tmp = [];
        if (!empty($routes)) {
            $allowed = self::getAllowed();
            foreach ($routes as $key => $value) {
                if (!empty($value) && $key == 'avaliable') {
                    $res[$key] = [];
                    foreach ($value as $k => $v) {
                        if (!empty($allowed)) {
                            foreach ($allowed as $k1 => $v1) {
                                if (substr($v1, -1) === '*') {
                                    $route = rtrim($v1, "*");
                                    if (strpos($v, $route) === 1) {
                                        $tmp[] = $v;
                                    }
                                } else {
                                    if (ltrim($v1, "/") === ltrim($v, "/")) {
                                        $tmp[] = $v;
                                    }
                                }
                            }
                        }
                    }
                    $res[$key] = array_diff($value, $tmp);
                } else {
                    $res[$key] = $value;
                }
            }
        }
        return $res;
    }

    public static function getcontrollersandactions()
    {
        $controllerlist = [];
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controllerlist[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controllerlist);
        $fulllist = [];
        foreach ($controllerlist as $controller):
            $handle = fopen('../controllers/' . $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
                        endif;
                    endif;
                }
            }
            fclose($handle);
        endforeach;
        return $fulllist;
    }

    public static function jsonParse($val)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [
            'status' => 500,
            'message' => 'no data',
            'value' => ''
        ];
        if (!empty($val)) {
            $data['status'] = 200;
            $data['message'] = 'success';
            $data['value'] = $val;
        }
        return $data;
    }

    public static function getAllowed()
    {
        return Yii::$app->db->createCommand('SELECT allowed FROM allowed')->queryColumn();
    }

    public static function getPrimaryKeyName($model)
    {
        $pk = $model->tableSchema->primaryKey;
        return !empty($pk[0]) ? $pk[0] : null;
    }

    public static function toString($data = [])
    {
        $res = '';
        if (!empty($data) && is_array($data)) {
            foreach ($data as $value) {
                $res .= $value;
                $res .= ', ';
            }
        }
        return rtrim($res, ', ');
    }

    /**
     * Safe way to access array or public property from an object.
     *
     * @param mixed  $stack
     * @param string $offset
     * @param mixed  $default
     *
     * @return mixed
     *
     */
    public static function def($stack, $offset, $default = null)
    {
        if (is_array($stack)) {
            if (array_key_exists($offset, $stack)) {
                return $stack[$offset];
            }
        } elseif (is_object($stack)) {
            if (property_exists($stack, $offset)) {
                return $stack->{$offset};
            } elseif ($stack instanceof ArrayAccess) {
                return $stack[$offset];
            } elseif (method_exists($stack, '__isset')) {
                if ($stack->__isset($offset)) {
                    if (method_exists($stack, '__get')) {
                        return $stack->__get($offset, $default);
                    }

                    return $stack->$offset;
                }
            } else {
                return self::def((array) $stack, $offset, self::value($default));
            }
        }

        return self::value($default);
    }

    public static function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }

}
