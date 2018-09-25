<?php

namespace app\modules\admin\models;

use Yii;

class Allowed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%allowed}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allowed'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Allowed' => Yii::t('rbac-admin', 'Allowed'),
        ];
    }

}
