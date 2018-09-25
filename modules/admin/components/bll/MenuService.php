<?php

namespace app\modules\admin\components\bll;

use Yii;

class MenuService implements
    \app\modules\admin\components\bll\IMenuService,
    \app\modules\admin\components\bll\IMenuLayoutService
{
    private $groupProvider;
    private $menuProvider;
    private $routeProvider;

    public function __construct()
    {
        Yii::$container->setSingleton('app\modules\admin\components\dal\IMenuGroupProvider',
            'app\modules\admin\components\dal\GroupProvider');
        Yii::$container->setSingleton('app\modules\admin\components\dal\IMenuProvider',
            'app\modules\admin\components\dal\MenuProvider');
        Yii::$container->setSingleton('app\modules\admin\components\dal\IRouteProvider',
            'app\modules\admin\components\dal\RouteProvider');

        $this->groupProvider = Yii::$container->get('app\modules\admin\components\dal\IMenuGroupProvider');
        $this->menuProvider = Yii::$container->get('app\modules\admin\components\dal\IMenuProvider');
        $this->routeProvider = Yii::$container->get('app\modules\admin\components\dal\IRouteProvider');
    }

    public function menuTypeInstance($id = null)
    {
        return $this->menuProvider->menuTypeInstance($id);
    }

    public function menuTypeSearchInstance()
    {
        return $this->menuProvider->menuTypeSearchInstance();
    }

    public function getAllGroup($order = 'group_id')
    {
        return $this->groupProvider->getAllGroup($order);
    }

    public function saveMenu($post, $id)
    {
        if (!empty($post) && !empty($id)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $list_id = !empty($post['remove']) ? $post['remove'] : [];
                $this->menuProvider->saveMenu($post, $id);
                $this->deleteMenu($list_id);
                $this->generateCache($id);
                $transaction->commit();

                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e);
            }
            return false;
        }
    }

    private function deleteMenu($list_id)
    {
        if (!empty($list_id)) {
            foreach ($list_id as $id) {
                $this->menuProvider->deleteMenu($id);
            }
            return true;
        }
        return false;
    }

    private function generateCache($menuType)
    {
        if (!empty($menuType)) {
            $data = $this->getMenu($menuType);
            if (!empty($data)) {
                return $this->menuProvider->saveCacheMenu($menuType, $data);
            }
        }
        return false;
    }

    public function getRoutes()
    {
        return $this->routeProvider->instance()->getRoutes();
    }

    public function deleteMenuType($id)
    {
        if (!empty($id)) {
            return $this->menuProvider->deleteMenuType($id);
        }
        return false;
    }

    public function getAllMenu($menuType)
    {
        if (!empty($menuType)) {
            return $this->menuProvider->getAllMenu($menuType);
        }
        return null;
    }

    private function getMenu($type = 'backend-menu')
    {
        $menu = [];
        $models = $this->menuProvider->getAllMenu($type);
        foreach ($models as $key => $val) {
            if (!$val->attributes['menu_parent']) {
                $items = [
                    'url' => $val->attributes['menu_url'],
                    'label' => $val->attributes['label'],
                    'icon' => $val->attributes['class'],
                    'content' => $val->attributes['description'],
                    'assign' => isset($val->menuGroups) ? self::getMenuGroup($val->menuGroups) : [],
                ];
                $menu[] = self::rebuildArray($models, $items, $val->attributes['menu_id']);
            }
        }
        return $menu;
    }

    private static function rebuildArray($models, $data = [], $id = null)
    {
        if (!empty($models)) {
            foreach ($models as $key => $val) {
                if ($val->attributes['menu_parent'] == $id) {
                    $items = [
                        'url' => $val->attributes['menu_url'],
                        'label' => $val->attributes['label'],
                        'icon' => $val->attributes['class'],
                        'content' => $val->attributes['description'],
                        'assign' => isset($val->menuGroups) ? self::getMenuGroup($val->menuGroups) : [],
                    ];
                    $data['items'][] = self::rebuildArray($models, $items, $val->attributes['menu_id']);
                }
            }
        }
        return $data;
    }

    private static function getMenuGroup($menuGroup)
    {
        $result = [];
        if (!empty($menuGroup)) {
            foreach ($menuGroup as $key => $value) {
                $result[] = $value->group_id;
            }
        }
        return $result;
    }

    public function saveMenuType($model, $id = null)
    {
        if (!empty($model)) {
            return $this->menuProvider->saveMenuType($model, $id);
        }
        return false;
    }

    public function getMenuCache($type = 'backend-menu')
    {
        $menu = $this->menuProvider->getMenuCache($type);
        return !empty($menu->data) ? unserialize($menu->data) : [];
    }
}
