<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "{{%dcl_field_config}}".
 *
 * @property integer $id
 * @property string $node_type
 * @property string $field_name
 * @property string $type
 * @property integer $required
 * @property string $message
 * @property integer $active
 * @property resource $data
 * @property integer $timestamp
 */
class DclFieldConfig extends \yii\db\ActiveRecord
{
    const TBL_PREFIX = 'field_';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dcl_field_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['node_type', 'field_name', 'type'], 'required'],
            [['required', 'active', 'timestamp'], 'integer'],
            [['data'], 'string'],
            [['field_name'], 'unique'],
            [['node_type', 'field_name'], 'string', 'max' => 32],
            [['type'], 'string', 'max' => 128],
            [['message'], 'string', 'max' => 255],

            ['field_name', 'filter', 'filter' => function ($value) {
                $value = trim($value);
                return str_replace(' ','-',$value);
            }],

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
            'field_name' => Yii::t('app', 'Label'),
            'type' => Yii::t('app', 'Type'),
            'required' => Yii::t('app', 'Required'),
            'message' => Yii::t('app', 'Message'),
            'active' => Yii::t('app', 'Active'),
            'data' => Yii::t('app', 'Data'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }




    /**
     * [getTableName description]
     * @param  [type] $model [description]
     * @return [type]        [description]
     */
    public function getTableName($model) {
        $tblName = '{{' . self::TBL_PREFIX . $model->node_type . '_' . strtolower($model->field_name) . '}}';
        if (Yii::$app->db->tablePrefix !== null && strpos($tblName, '{{') !== false) {
            $tblName = preg_replace('/\{\{(.*?)\}\}/', Yii::$app->db->tablePrefix . '$1', $tblName);
        }
        $tableName = str_replace(' ','-',$tableName);
        return $tblName;
    }





    /**
     * [beforeSave description]
     * @param  [type] $insert [description]
     * @return [type]         [description]
     */
    // public function beforeSave($insert)
    // {
    //     if (parent::beforeSave($insert))
    //     {
    //         if ($this->isNewRecord && $this->node_type && $this->field_name)
    //         {
    //             $type = str_replace(' ', '-', trim($this->name));
    //             $regx = "/[^-a-zA-Z0-9]+/";
    //             $this->node_type = strtolower(preg_replace($regx, "", $type));
    //             $this->module = 'node';
    //         }
    //         return TRUE;
    //     }
    //     return FALSE;
    // }  
    

    /**
     * [afterSave description]
     * @param  [type] $insert            [description]
     * @param  [type] $changedAttributes [description]
     * @return [type]                    [description]
     */
    public function afterSave($insert, $changedAttributes){

        parent::afterSave($insert, $changedAttributes);
        if ($insert) {

            if ($this->type == 'file') {
                \Yii::$app->db->createCommand()->createTable( $this->getTableName($this) , [
                    'id' => \yii\db\Schema::TYPE_PK,
                    'node_id' => 'int(11) NOT NULL',
                    'language' => 'varchar(32) NOT NULL',
                    'name' => 'varchar(128) NOT NULL',
                    'name_thumbnail' => 'varchar(128) NOT NULL',
                    'path' => 'varchar(128) NOT NULL',
                    'path_thumbnail' => 'varchar(128) NOT NULL',
                    'description' => 'varchar(500) NOT NULL',
                    'timestamp' => 'int(11) NOT NULL',
                    // 'title' => \yii\db\Schema::TYPE_STRING . ' NOT NULL',
                    // 'content' => \yii\db\Schema::TYPE_TEXT,
                    ],'ENGINE=InnoDB DEFAULT CHARSET=latin1')->execute();
            }
            else
            {
                \Yii::$app->db->createCommand()->createTable( $this->getTableName($this) , [
                    'id' => \yii\db\Schema::TYPE_PK,
                    'node_id' => 'int(11) NOT NULL',
                    'language' => 'varchar(32) NOT NULL',
                    'name' => 'varchar(128) NOT NULL',
                    'timestamp' => 'int(11) NOT NULL',
                    ],'ENGINE=InnoDB DEFAULT CHARSET=latin1')->execute();

            }

            // \Yii::$app-><get></get>Session()->setFlash('danger', implode(' glue ', $insert));
            // \Yii::$app->getSession()->setFlash('danger', $this->field_name);
        }

    }   


    /**
     * [afterDelete description]
     * @return [type] [description]
     */
    public function afterDelete()
    {
        $tableName = $this->getTableName($this);
        $tableSchema = Yii::$app->db->schema->getTableSchema($tableName);

        if ($tableSchema !== null ) {
            \Yii::$app->db->createCommand()->dropTable($tableName)->execute();
            \Yii::$app->getSession()->setFlash('warning', $tableName.' dropped');
        }
        return;

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
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['timestamp'],
                    // \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }

}
