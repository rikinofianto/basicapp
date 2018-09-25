<?php

namespace app\modules\admin\models\form;

use Yii;
use yii\base\Model;

class User extends Model
{
    public $username;
    public $email;
    public $group_id = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'User Name',
            'group_id' => 'Group ID',
        ];
    }
}
