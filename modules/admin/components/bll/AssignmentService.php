<?php

namespace app\modules\admin\components\bll;

use Yii;
use app\modules\admin\models\Assignment;

class AssignmentService implements \app\modules\admin\components\bll\IAssignmentService
{
    private $groupProvider;

    public function __construct()
    {
        Yii::$container->setSingleton('app\modules\admin\components\bll\IAssignmentGroupProvider',
            'app\modules\admin\components\dal\GroupProvider');

        $this->groupProvider = Yii::$container->get('app\modules\admin\components\bll\IAssignmentGroupProvider');
    }

    public function groupSearchInstance()
    {
        return $this->groupProvider->groupSearchInstance();
    }

    public function instance($id, $user = null, $config = array())
    {
        return !empty($id) ? new Assignment($id, $user, $config) : null;
    }
}
