<?php

namespace app\modules\admin\components;

use Yii;
use app\modules\admin\models\User;
use app\modules\admin\components\Helper;

class UserIdentity
{
    public $user;
    private $group = [];

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->setGroup();
        $this->setState();
    }

    private function setState()
    {
        $session = Yii::$app->getSession();
        $session->set('user_id', $this->user->id);
        $session->set('group_id', $this->group);
    }

    public function setGroup()
    {
        if (!empty($this->user->userGroup)) {
            foreach ($this->user->userGroup as $key => $value) {
                $this->group[] = $value->group_id;
            }
        }
        return $this;
    }

}
