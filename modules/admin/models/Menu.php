<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\components\Configs;
use yii\db\Query;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id Menu id(autoincrement)
 * @property string $name Menu name
 * @property integer $parent Menu parent
 * @property string $route Route for this menu
 * @property integer $order Menu order
 * @property string $data Extra information for this menu
 *
 * @property Menu $menuParent Menu parent
 * @property Menu[] $menus Menu children
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Menu extends \yii\db\ActiveRecord
{
    public $parent_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Configs::instance()->menuTable;
    }

    /**
     * @inheritdoc
     */
    public static function getDb()
    {
        if (Configs::instance()->db !== null) {
            return Configs::instance()->db;
        } else {
            return parent::getDb();
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label','menu_type'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => Yii::t('rbac-admin', 'ID'),
            'label' => Yii::t('rbac-admin', 'Menu Name'),
            'description' => Yii::t('rbac-admin', 'Description'),
            'menu_custom' => Yii::t('rbac-admin', 'Is Custom'),
            'menu_type' => Yii::t('rbac-admin', 'Menu Type (Category)'),
            'menu_parent' => Yii::t('rbac-admin', 'Parent Menu'),
            'menu_order' => Yii::t('rbac-admin', 'Menu Order'),
            'menu_url' => Yii::t('rbac-admin', 'URL'),
            'class' => Yii::t('rbac-admin', 'Class'),
            'status' => Yii::t('rbac-admin', 'Status'),
        ];
    }

    public function getMenuGroups()
    {
        return $this->hasMany(MenuGroup::className(), ['menu_id' => 'menu_id']);
    }
}
