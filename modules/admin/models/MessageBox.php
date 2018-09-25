<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%message_box}}".
 *
 * @property integer $message_box_id
 * @property integer $message_id
 * @property string $type
 * @property string $receiver
 * @property string $date
 *
 * @property Message $message
 */
class MessageBox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message_box}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'receiver'], 'required'],
            [['message_id'], 'integer'],
            [['type'], 'string'],
            [['date', 'is_read', 'is_deleted'], 'safe'],
            [['receiver'], 'string', 'max' => 100],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::className(), 'targetAttribute' => ['message_id' => 'message_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_box_id' => Yii::t('rbac-admin', 'Message Box ID'),
            'message_id' => Yii::t('rbac-admin', 'Message ID'),
            'type' => Yii::t('rbac-admin', 'Type'),
            'receiver' => Yii::t('rbac-admin', 'Receiver'),
            'date' => Yii::t('rbac-admin', 'Date'),
            'is_read' => Yii::t('rbac-admin', 'Read'),
            'is_deleted' => Yii::t('rbac-admin', 'Delete'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['message_id' => 'message_id']);
    }
}
