<?php

namespace app\modules\admin\components\dal;

interface IMenuGroupProvider
{
    public function getAllGroup($order = 'group_id');
}
