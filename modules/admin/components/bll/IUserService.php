<?php

namespace app\modules\admin\components\bll;

interface IUserService
{
    public function userSearchInstance();
    public function login($model);
    public function createUser($model);
    public function changePassword($model);
    public function getRedirectUrl($userId);
    public function getAllGroup($order = 'group_id');
    public function setGroup($model);
    public function createAllUserGroup($post, $model);
    public function updateAllUserGroup($post, $userId);
    public function sendEmail($email);
    public function resetPassword($password);
}
