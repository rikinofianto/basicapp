<?php

namespace app\modules\admin\components\bll;

interface IAssignmentService
{
    public function groupSearchInstance();
    public function instance($id, $user = null, $config = array());
}
