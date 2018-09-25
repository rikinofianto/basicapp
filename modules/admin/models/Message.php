<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $message_id
 * @property string $subject
 * @property string $message
 * @property string $is_draft
 * @property string $is_deleted
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 *
 * @property MessageBox[] $messageBoxes
 * @property MessageDestination[] $messageDestinations
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'message', 'is_draft', 'created_by'], 'required'],
            [['message', 'is_draft', 'is_deleted'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_id' => Yii::t('rbac-admin', 'Message ID'),
            'subject' => Yii::t('rbac-admin', 'Subject'),
            'message' => Yii::t('rbac-admin', 'Message'),
            'is_draft' => Yii::t('rbac-admin', 'Is Draft'),
            'is_deleted' => Yii::t('rbac-admin', 'Is Deleted'),
            'created_by' => Yii::t('rbac-admin', 'Created By'),
            'created_at' => Yii::t('rbac-admin', 'Created At'),
            'updated_by' => Yii::t('rbac-admin', 'Updated By'),
            'updated_at' => Yii::t('rbac-admin', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageBoxes()
    {
        return $this->hasMany(MessageBox::className(), ['message_id' => 'message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageDestinations()
    {
        return $this->hasMany(MessageDestination::className(), ['message_id' => 'message_id']);
    }

    public function getMessageIn()
    {
        return $this->hasOne(MessageBox::className(), ['message_id' => 'message_id'])
            ->where(['type' => 'in']);
    }

    public function getMessageOut()
    {
        return $this->hasOne(MessageBox::className(), ['message_id' => 'message_id'])
            ->where(['type' => 'out']);
    }
    
}
