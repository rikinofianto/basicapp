<?php

namespace app\modules\admin\components;

use Yii;
use yii\helpers\Html;

class ActionHelper
{
    public static function menu($model)
    {
        $link = '';
        if (!empty($model)) {
            $link = Html::a(Yii::t('rbac-admin', 'Create'), ['/admin/menu/create']);
        }
        return $link;
    }
}
