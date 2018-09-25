<?php

namespace app\modules\admin\components\dal;

use app\modules\admin\models\Route;

class RouteProvider implements \app\modules\admin\components\dal\IRouteProvider
{
    public function instance()
    {
        return new Route();
    }
}
