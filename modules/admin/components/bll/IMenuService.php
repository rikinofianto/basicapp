<?php

namespace app\modules\admin\components\bll;

Interface IMenuService
{
    public function menuTypeInstance($id = null);
    public function menuTypeSearchInstance();
    public function getAllGroup($order = 'group_id');
    public function saveMenu($post, $id);
    public function getRoutes();
    public function deleteMenuType($id);
    public function getAllMenu($menu_type);
    public function saveMenuType($model, $id = null);
}
