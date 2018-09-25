<?php

namespace app\modules\admin\components\dal;

use Yii;
use app\modules\admin\models\Menu;
use app\modules\admin\models\MenuType;
use app\modules\admin\models\UserGroup;
use app\modules\admin\models\MenuGroup;
use app\modules\admin\models\CacheMenu;
use app\modules\admin\models\form\MenuType as MenuTypeForm;
use app\modules\admin\components\Helper;
use app\modules\admin\models\searchs\MenuType as MenuTypeSearch;

class MenuProvider implements \app\modules\admin\components\dal\IMenuProvider
{
    public function menuTypeInstance($id = null)
    {
        $model = new MenuTypeForm();
        $model->scenario = 'insert';
        if (!empty($id)) {
            $typeModel = MenuType::findOne($id);
            $model->attributes = $typeModel->attributes;
            $model->scenario = 'default';
        }
        return $model;
    }

    public function menuTypeSearchInstance()
    {
        return new MenuTypeSearch();
    }

    private static function loadMenu($id = null)
    {
        return Menu::findOne($id);
    }

    private static function allMenu($menuType)
    {
        return Menu::find()->where(['menu_type' => $menuType])
            ->joinWith('menuGroups')
            ->orderBy('menu_order')
            ->all();
    }

    public function getAllMenu($menuType)
    {
        return self::allMenu($menuType);
    }

    public function getMenuCache($type = 'backend-menu')
    {
        return CacheMenu::findOne(['cid' => $type]);
    }

    public function deleteMenu($id)
    {
        $deleteMenu = self::loadMenu($id);
        if (!empty($deleteMenu)) {
            return $deleteMenu->delete();
        }
        return false;
    }

    public function saveMenuType($model, $id = null)
    {
        if (!empty($model)) {
            if (!empty($id)) {
                $menu_model = MenuType::findOne($id);
            } else {
                $menu_model = new MenuType();
            }
            $menu_model->attributes = $model->attributes;
            if ($menu_model->validate() && $menu_model->save()) {
                return true;
            }
        }
        return false;
    }

    private static function saveMenuGroup($menuId, $groupId)
    {
        if (!empty($menuId) && !empty($groupId)) {
            $model = new MenuGroup();
            $model->menu_id = intval($menuId);
            $model->group_id = $groupId;
            if ($model->validate() && $model->save()) {
                return true;
            }
        }
        return false;
    }

    public function deleteMenuType($id)
    {
        $transaction = Yii::$app->db->beginTransaction();

        $type = MenuType::findOne($id);
        $cache = CacheMenu::findOne($id);

        if (!empty($type)) {
            if ($type->delete()) {
                if (!empty($cache)) {
                    $cache->delete();
                }
                $transaction->commit();
                return true;
            }
            $transaction->rollBack();
        }
        return false;
    }

    public function saveMenu($data, $id)
    {
        if (!empty($data['item'])) {
            $parent = [];
            $dummy_id = null;
            foreach ($data['item'] as $keys => $row) {
                if (empty($row['menu_id'])) {
                    $model = new Menu();
                } else {
                    $model = Menu::findOne($row['menu_id']);
                }
                $group =  [];
                foreach ($row as $key => $value) {
                    // set $group value for save then
                    if ($key == "group") {
                        $group = $value;
                    } elseif($key == "dummy_id") {
                        $dummy_id = $value;
                    } else {
                        $model->{$key} = $value;
                    }

                    if ($key == "menu_parent") {
                        if (!is_numeric($value)) {
                            if (isset($parent[$value])) {
                                $model->$key = $parent[$value];
                            }
                        } else {
                            $model->$key = $value;
                        }
                    }
                }
                $model->menu_type = $id;

                if ($model->validate() && $model->save()) {
                    // prepare array for parent
                    $parent[$dummy_id] = $model->menu_id;
                    MenuGroup::deleteAll(['menu_id' => intval($model->menu_id)]);
                        if (!empty($group)) {
                        foreach ($group as $groupId) {
                            self::saveMenuGroup($model->menu_id, $groupId);
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function saveCacheMenu($menuType, Array $data)
    {
        $cacheMenuModel = CacheMenu::findOne(['cid' => $menuType]);
        if (!$cacheMenuModel) {
            $cacheMenuModel = new CacheMenu();
            $cacheMenuModel->cid = $menuType;
        }
        $cacheMenuModel->data = serialize($data);
        $cacheMenuModel->created = strtotime(date('Y-m-d H:i:s'));
        if ($cacheMenuModel->validate() && $cacheMenuModel->save()) {
            return true;
        }
        return false;
    }

}
