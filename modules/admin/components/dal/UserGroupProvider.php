<?php

namespace app\modules\admin\components\dal;

use app\modules\admin\models\UserGroup;

class UserGroupProvider implements 
    \app\modules\admin\components\dal\IUserGroupProvider,
    \app\modules\admin\components\dal\IMessageUserGroupProvider
{
    public function findByGroupId($groupId)
    {
        return UserGroup::findAll($groupId);
    }

    public function deleteAllUserGroup($userId)
    {
        return UserGroup::deleteAll('user_id = :id', [':id' => $userId]);
    }

    public function saveUserGroup($userId, $groupId)
    {
        $group = new UserGroup();
        $group->user_id = $userId;
        $group->group_id = $groupId;
        return $group->save();
    }
}
