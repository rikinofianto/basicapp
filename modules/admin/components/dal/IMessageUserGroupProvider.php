<?php

namespace app\modules\admin\components\dal;

interface IMessageUserGroupProvider
{
    public function findByGroupId($groupId);
}
