<?php

namespace app\modules\admin\models;

use Yii;

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
class CacheMenu extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cache_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid','data','created'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => Yii::t('rbac-admin', 'Cache ID'),
            'data' => Yii::t('rbac-admin', 'Data Cache'),
            'created' => Yii::t('rbac-admin', 'Waktu Dibuat'),
            'expired' => Yii::t('rbac-admin', 'Waktu Habis'),
        ];
    }

}
