<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%dcl_field_data_body}}".
 *
 * @property integer $id
 * @property string $node_type
 * @property string $bundle
 * @property integer $deleted
 * @property string $node_id
 * @property string $language
 * @property integer $delta
 * @property string $title
 * @property string $body_value
 * @property string $body_summary
 * @property string $body_format
 * @property string $meta_tag
 * @property string $slideshow
 */
class DclFieldDataBody extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dcl_field_data_body}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deleted', 'node_id', 'language', 'delta'], 'required'],
            [['deleted', 'node_id', 'delta'], 'integer'],
            [['body_value', 'body_summary', 'slideshow'], 'string'],
            [['node_type', 'bundle'], 'string', 'max' => 128],
            [['language'], 'string', 'max' => 32],
            [['title', 'body_format', 'meta_tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'node_type' => Yii::t('app', 'Type'),
            'bundle' => Yii::t('app', 'Bundle'),
            'deleted' => Yii::t('app', 'Deleted'),
            'node_id' => Yii::t('app', 'Node ID'),
            'language' => Yii::t('app', 'Language'),
            'delta' => Yii::t('app', 'Delta'),
            'title' => Yii::t('app', 'Title'),
            'body_value' => Yii::t('app', 'Body Value'),
            'body_summary' => Yii::t('app', 'Body Summary'),
            'body_format' => Yii::t('app', 'Body Format'),
            'meta_tag' => Yii::t('app', 'Meta Tag'),
            'slideshow' => Yii::t('app', 'Slideshow'),
            'changed' => Yii::t('app', 'Updated'),
            'status' => Yii::t('app', 'Status'),
            'published' => Yii::t('app', 'Published'),
        ];
    }

    /**
     * [getNode description]
     * @return [type] [description]
     */
    public function getNode()
    {
        return $this->hasOne(DclNode::className(), ['node_id' => 'node_id']);
    }

    /**
     * [getNodeType description]
     * @return [type] [description]
     */
    public function getNodeType()
    {
        return $this->hasOne(DclNodeType::className(), ['node_type' => 'node_type']);
    }



}
