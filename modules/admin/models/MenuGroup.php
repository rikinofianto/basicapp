<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\components\Configs;
use yii\db\Query;

/**
 * This is the model class for table "group".
 *
 * @property string $group_id
 * @property integer $menu_id
 *
 */
class MenuGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'group_id'], 'required'],
            [['menu_id'], 'integer'],
            [['group_id'], 'string', 'max' => 64],
        ];
    }

    public function getGroups()
    {
        return $this->hasOne(Group::className(), ['group_id' => 'group_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => 'Menu ID',
            'group_id' => 'Group ID',
        ];
    }

    // public function beforeValidate()
    // {
    //     // ...
    // }

    // public function beforeSave($insert)
    // {
    //     // ...
    // }

}
