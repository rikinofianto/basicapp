<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\models\Tree;

/**
 * This is the model class for table "group".
 *
 * @property string $group_id
 * @property string $name
 * @property string $detail
 * @property string $configuration
 * @property integer $level
 * @property integer $order
 * @property integer $left
 * @property integer $right
 * @property string $parent_id
 * @property string $path
 * @property string $url
 *
 * @property UserGroup[] $userGroups
 * @property User[] $users
 */
class Group extends Tree
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{%group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'name'], 'required'],
            [['name'], 'unique', 'message' => 'Group Name Already Exist'],
            [['detail', 'configuration', 'url'], 'string'],
            [['level', 'order', 'left', 'right'], 'integer'],
            [['group_id', 'name', 'parent_id'], 'string', 'max' => 64],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'name' => 'Name',
            'detail' => 'Detail',
            'configuration' => 'Configuration',
            'level' => 'Level',
            'order' => 'Order',
            'left' => 'Left',
            'right' => 'Right',
            'parent_id' => 'Parent ID',
            'path' => 'Path',
            'url' => 'Url',
        ];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord && $this->name) {
            $type = str_replace(' ', '-', trim($this->name));
            $regx = "/[^-a-zA-Z0-9]+/";
            $this->group_id = strtolower(preg_replace($regx, "", $type));
        }
        return true && parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if (empty($this->parent_id)) {
            $this->parent_id = "master";
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserGroups()
    {
        return $this->hasMany(UserGroup::className(), ['group_id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_group', ['group_id' => 'group_id']);
    }

    public function getItems($id)
    {
        $manager = Yii::$app->getAuthManager();
        $avaliable = [];
        foreach (array_keys($manager->getRoles()) as $name) {
            $avaliable[$name] = 'role';
        }

        foreach (array_keys($manager->getPermissions()) as $name) {
            if ($name[0] != '/') {
                $avaliable[$name] = 'permission';
            }
        }

        $assigned = [];
        //this line

        foreach ($manager->getAssignments($id) as $item) {
            $assigned[$item->roleName] = $avaliable[$item->roleName];
            unset($avaliable[$item->roleName]);
        }

        return[
            'avaliable' => $avaliable,
            'assigned' => $assigned
        ];
    }
}
