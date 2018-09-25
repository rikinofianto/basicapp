<?php

namespace app\modules\admin\components\dal;

use Yii;
use app\modules\admin\models\Allowed;

class AllowedProvider implements \app\modules\admin\components\dal\IAllowedProvider
{
    public function add($route)
    {
        if (!empty($route)) {
            $model = new Allowed();
            $model->allowed = $route;
            return $model->save();
        }
        return false;
    }

    public function remove($route)
    {
        if (!empty($route)) {
            return Allowed::deleteAll(['allowed' => $route]);
        }
        return false;
    }

}
