<?php

namespace app\modules\admin\components\dal;

interface IMenuProvider
{
    public function menuTypeInstance($id = null);
    public function menuTypeSearchInstance();
    public function getAllMenu($menuType);
    public function getMenuCache($type = 'backend-menu');
    public function saveMenuType($model, $id = null);
    public function saveMenu($data, $id);
    public function saveCacheMenu($menuType, Array $data);
    public function deleteMenu($id);
    public function deleteMenuType($id);
}
