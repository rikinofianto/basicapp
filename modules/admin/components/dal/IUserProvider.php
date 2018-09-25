<?php

namespace app\modules\admin\components\dal;

interface IUserProvider
{
    public function userSearchInstance();
    public function findByUsername($username);
    public function createUser($model);
    public function changePassword($model);
    public function passwordResetRequest($email);
    public function resetPassword($password);
}
