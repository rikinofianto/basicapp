<?php

namespace app\modules\admin\models\form;

use Yii;
use yii\base\Model;

class MenuType extends Model
{
    public $title;
    public $description;
    public $menu_type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'unique', 'on' => 'insert', 'targetClass' => 'app\modules\admin\models\MenuType', 'message' => 'Category Menu Already Exist'],
            [['title'], 'string', 'max' => 225],
            [['description', 'menu_type'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('rbac-admin', 'Menu Type'),
            'description' => Yii::t('rbac-admin', 'Decription'),
        ];
    }

}
