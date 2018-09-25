<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%dcl_node_type}}".
 *
 * @property string $node_type
 * @property string $name
 * @property string $module
 * @property string $description
 * @property integer $created
 */
class DclNodeType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dcl_node_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['description'], 'string'],
            [['created'], 'integer'],
            [['node_type'], 'string', 'max' => 32],
            [['name', 'module'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'node_type' => Yii::t('app', 'Node Type'),
            'name' => Yii::t('app', 'Name'),
            'module' => Yii::t('app', 'Module'),
            'description' => Yii::t('app', 'Description'),
            'created' => Yii::t('app', 'Created'),
        ];
    }





    /**
     * [beforeSave description]
     * @param  [type] $insert [description]
     * @return [type]         [description]
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->isNewRecord && $this->name)
            {
                $type = str_replace(' ', '-', trim($this->name));
                $regx = "/[^-a-zA-Z0-9]+/";
                $this->node_type = strtolower(preg_replace($regx, "", $type));
                $this->module = 'node';
            }
            return TRUE;
        }
        return FALSE;
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created'],
                ],
            ],
        ];
    }





}
