<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%dcl_media_content}}".
 *
 * @property integer $media_content_id
 * @property integer $parent_id
 * @property integer $created
 * @property integer $updated
 * @property string $create_by
 * @property string $path
 * @property string $DESC
 * @property integer $type
 * @property string $setting
 *
 * @property DclMedia $parent
 */
class DclMediaContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dcl_media_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'path'], 'required'],
            [['parent_id', 'created', 'updated', 'type'], 'integer'],
            [['DESC', 'setting'], 'string'],
            [['create_by'], 'string', 'max' => 50],
            [['path'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => DclMedia::className(), 'targetAttribute' => ['parent_id' => 'media_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'media_content_id' => Yii::t('app', 'Media Content ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'create_by' => Yii::t('app', 'Create By'),
            'path' => Yii::t('app', 'Path'),
            'DESC' => Yii::t('app', 'Desc'),
            'type' => Yii::t('app', 'Type'),
            'setting' => Yii::t('app', 'Setting'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(DclMedia::className(), ['media_id' => 'parent_id']);
    }

    
    /**
     * @inheritdoc
     * @return type array
     */ 
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }
}
