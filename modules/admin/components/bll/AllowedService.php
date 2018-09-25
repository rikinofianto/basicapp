<?php

namespace app\modules\admin\components\bll;

use Yii;
use Exception;
use app\modules\admin\components\Helper;

class AllowedService implements \app\modules\admin\components\bll\IAllowedService
{
    private $allowedProvider;
    private $routeProvider;

    public function __construct()
    {
        Yii::$container->setSingleton('app\modules\admin\components\dal\IAllowedProvider',
            'app\modules\admin\components\dal\AllowedProvider');
        Yii::$container->setSingleton('app\modules\admin\components\dal\IRouteProvider',
            'app\modules\admin\components\dal\RouteProvider');

        $this->allowedProvider = Yii::$container->get('app\modules\admin\components\dal\IAllowedProvider');
        $this->routeProvider = Yii::$container->get('app\modules\admin\components\dal\IRouteProvider');
    }

    public function routeInstance()
    {
        return $this->routeProvider->instance();
    }

    public function add($routes)
    {
        if (!empty($routes) && is_array($routes)) {
            foreach ($routes as $route) {
                try {
                    if (substr($route, 0, 1) == '/') {
                        $route = substr($route, 1);
                    }
                    $this->allowedProvider->add($route);
                } catch (Exception $exc) {
                    Yii::error($exc->getMessage(), __METHOD__);
                }
            }
            Helper::invalidate();
        }
    }

    public function remove($routes)
    {
        if (!empty($routes) && is_array($routes)) {
            foreach ($routes as $route) {
                try {
                    $this->allowedProvider->remove($route);
                } catch (Exception $exc) {
                    Yii::error($exc->getMessage(), __METHOD__);
                }
            }
            Helper::invalidate();
        }
    }
}
