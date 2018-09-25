<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "group".
 *
 * @property string $group_id
 * @property string $name
 * @property string $detail
 * @property string $configuration
 * @property integer $level
 * @property integer $order
 * @property integer $left
 * @property integer $right
 * @property string $parent_id
 * @property string $path
 * @property string $url
 *
 * @property UserGroup[] $userGroups
 * @property User[] $users
 */
class MenuType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'unique', 'message' => 'Category Menu Already Exist'],
            [['menu_type'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 50],
            [['description'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_type' => Yii::t('rbac-admin', 'Menu Type (unique)'),
            'title' => Yii::t('rbac-admin', 'Menu Name'),
            'description' => Yii::t('rbac-admin', 'Decription'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord && $this->title) {
                $type = str_replace(' ', '-', trim($this->title));
                $regx = "/[^-a-zA-Z0-9]+/";
                $this->menu_type = strtolower(preg_replace($regx, "", $type));
            }
            return true;
        }
        return false;
    }

}
