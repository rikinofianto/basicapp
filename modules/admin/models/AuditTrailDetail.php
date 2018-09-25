<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "audit_trail_detail".
 *
 * @property integer $id
 * @property integer $audit_trail_id
 * @property string $old_value
 * @property string $new_value
 * @property string $action
 * @property string $model
 * @property string $field
 * @property string $stamp
 * @property string $user_id
 * @property string $model_id
 * @property string $user_name
 * @property string $ip_address
 * @property string $url_referer
 * @property string $browser
 * @property integer $module_id
 */
class AuditTrailDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%audit_trail_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['audit_trail_id', 'action', 'model', 'stamp', 'model_id'], 'required'],
            [['audit_trail_id', 'module_id'], 'integer'],
            [['old_value', 'new_value'], 'string'],
            [['stamp'], 'safe'],
            [['action', 'model', 'field', 'user_id', 'model_id', 'user_name', 'ip_address', 'url_referer', 'browser'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'audit_trail_id' => 'Audit Trail ID',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'action' => 'Action',
            'model' => 'Model',
            'field' => 'Field',
            'stamp' => 'Stamp',
            'user_id' => 'User ID',
            'model_id' => 'Model ID',
            'user_name' => 'User Name',
            'ip_address' => 'Ip Address',
            'url_referer' => 'Url Referer',
            'browser' => 'Browser',
            'module_id' => 'Module ID',
        ];
    }
}
