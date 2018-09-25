<?php

namespace app\modules\admin\components\dal;

use app\modules\admin\models\Group;
use app\modules\admin\models\searchs\Group as GroupSearch;

class GroupProvider implements
    \app\modules\admin\components\dal\IGroupProvider,
    \app\modules\admin\components\dal\IAssignmentGroupProvider,
    \app\modules\admin\components\dal\IMenuGroupProvider
{
    public function groupInstance()
    {
        return new Group();
    }

    public function groupSearchInstance()
    {
        return new GroupSearch();
    }

    public function getAllGroup($order = 'group_id')
    {
        return Group::find()->orderBy($order)->all();
    }

    public function searchGroup($group = null)
    {
        return Group::find()->andFilterWhere(['like', 'name', $group])->all();
    }
}
