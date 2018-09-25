<?php

namespace app\modules\admin\components\bll;

interface IGroupService
{
    public function groupInstance();
    public function groupSearchInstance();
    public function getSavedRoutes();
/*
    public function getAllGroup($order = 'group_id');
    public function getAllGroupByName($key);
    public function getAllUserGroup();
    public function getAllUserGroupByGroupId($group_id = null);
    public function updateAllUserGroup($post, $user_id);
    public function getUserAttributes($models, $user_id, $attr);
    public function search($name = null, $type = null);
    public function getUserNameById($user_id = null);
*/
}
