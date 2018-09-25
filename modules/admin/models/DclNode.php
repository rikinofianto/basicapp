<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%dcl_node}}".
 *
 * @property integer $node_id
 * @property string $node_type
 * @property string $node_menu
 * @property integer $status
 * @property integer $created
 * @property integer $changed
 * @property string $timestamp
 * @property integer $publish
 * @property string $category
 * @property string $created_by
 */
class DclNode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dcl_node}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created', 'changed', 'publish'], 'integer'],
            [['timestamp'], 'safe'],
            [['node_type'], 'string', 'max' => 32],
            [['node_menu', 'category'], 'string', 'max' => 255],
            [['created_by'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'node_id' => Yii::t('app', 'Node ID'),
            'node_type' => Yii::t('app', 'Node Type'),
            'node_menu' => Yii::t('app', 'Node Menu'),
            'status' => Yii::t('app', 'Status'),
            'created' => Yii::t('app', 'Created'),
            'changed' => Yii::t('app', 'Changed'),
            'timestamp' => Yii::t('app', 'Timestamp'),
            'publish' => Yii::t('app', 'Publish'),
            'category' => Yii::t('app', 'Category'),
            'created_by' => Yii::t('app', 'Created By'),
        ];
    }


    public function getFieldDataBody()
    {
        return $this->hasOne(DclFieldDataBody::className(), ['node_id' => 'node_id']);
    }
}
