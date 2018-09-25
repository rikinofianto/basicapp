<?php

namespace app\modules\admin\components\bll;

use Yii;
use yii\helpers\ArrayHelper;

class GroupService implements \app\modules\admin\components\bll\IGroupService
{
    private $groupProvider;
    private $routeProvider;

    public function __construct()
    {
        Yii::$container->setSingleton('app\modules\admin\components\bll\IGroupProvider',
            'app\modules\admin\components\dal\GroupProvider');
        Yii::$container->setSingleton('app\modules\admin\components\bll\IRouteProvider',
            'app\modules\admin\components\dal\RouteProvider');

        $this->groupProvider = Yii::$container->get('app\modules\admin\components\bll\IGroupProvider');
        $this->routeProvider = Yii::$container->get('app\modules\admin\components\bll\IRouteProvider');

    }

    public function groupInstance()
    {
        return $this->groupProvider->groupInstance();
    }

    public function groupSearchInstance()
    {
        return $this->groupProvider->groupSearchInstance();
    }

    public function getSavedRoutes()
    {
        return $this->routeProvider->instance()->getSavedRoutes();
    }

}
