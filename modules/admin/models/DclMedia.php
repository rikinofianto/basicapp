<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%dcl_media}}".
 *
 * @property integer $media_id
 * @property string $name
 * @property integer $created
 * @property integer $updated
 * @property string $desc
 * @property string $setting
 * @property string $path_name
 * @property string $create_by
 * @property string $privilege
 * @property integer $type
 * @property string $size
 * @property string $position
 * @property string $group
 */
class DclMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dcl_media}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created', 'updated', 'type'], 'integer'],
            [['setting', 'privilege', 'size', 'position'], 'string'],
            [['name'], 'string', 'max' => 80],
            [['desc'], 'string', 'max' => 200],
            [['path_name'], 'string', 'max' => 255],
            [['create_by', 'group'], 'string', 'max' => 50],
            // [['create_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'media_id' => Yii::t('app', 'Media ID'),
            'name' => Yii::t('app', 'Name'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'desc' => Yii::t('app', 'Description'),
            'setting' => Yii::t('app', 'Setting'),
            'path_name' => Yii::t('app', 'Path Name'),
            'create_by' => Yii::t('app', 'Create By'),
            'privilege' => Yii::t('app', 'Privilege'),
            'type' => Yii::t('app', 'Type'),
            'size' => Yii::t('app', 'Size'),
            'position' => Yii::t('app', 'Position'),
            'group' => Yii::t('app', 'Group'),
        ];
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
