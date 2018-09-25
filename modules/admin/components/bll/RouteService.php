<?php

namespace app\modules\admin\components\bll;

use Yii;

class RouteService implements \app\modules\admin\components\bll\IRouteService
{
    private $routeProvider;

    public function __construct()
    {
        Yii::$container->setSingleton('app\modules\admin\components\dal\IRouteProvider',
            'app\modules\admin\components\dal\RouteProvider');
        $this->routeProvider = Yii::$container->get('app\modules\admin\components\dal\IRouteProvider');
    }

    public function instance()
    {
        return $this->routeProvider->instance();
    }
}
