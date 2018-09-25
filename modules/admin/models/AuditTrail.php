<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "audit_trail".
 *
 * @property integer $audit_trail_id
 * @property string $old_value
 * @property string $new_value
 * @property string $action
 * @property string $model
 * @property string $field
 * @property string $stamp
 * @property string $user_id
 * @property string $user_name
 * @property string $ip_address
 * @property string $url_referer
 * @property string $browser
 * @property string $model_id
 */
class AuditTrail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%audit_trail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_value', 'new_value'], 'string'],
            [['action', 'model', 'stamp', 'model_id'], 'required'],
            [['stamp'], 'safe'],
            [['action', 'model', 'field', 'user_id', 'user_name', 'url_referer', 'browser', 'model_id'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'audit_trail_id' => 'Audit Trail ID',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'action' => 'Action',
            'model' => 'Model',
            'field' => 'Field',
            'stamp' => 'Stamp',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'ip_address' => 'Ip Address',
            'url_referer' => 'Url Referer',
            'browser' => 'Browser',
            'model_id' => 'Model ID',
        ];
    }
}
