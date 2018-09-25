<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\modules\admin\components\Helper;
use app\modules\admin\components\BaseController;

class AllowedController extends BaseController
{
    private $allowedService;

    public function __construct($id, $module, $config = [])
    {
        Yii::$container->setSingleton('app\modules\admin\components\bll\IAllowedService',
            'app\modules\admin\components\bll\AllowedService');
        $this->allowedService = Yii::$container->get('app\modules\admin\components\bll\IAllowedService');

        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'assign' => ['post'],
                    'remove' => ['post'],
                    'refresh' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Route models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->allowedService->routeInstance();
        $all_routes = $model->getRoutesAllowed();
        $routes = Helper::filterRoutes($all_routes, false);
        return $this->render('index', ['routes' => $routes]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->getResponse()->format = 'json';
        $routes = Yii::$app->getRequest()->post('route', '');
        $routes = preg_split('/\s*,\s*/', trim($routes), -1, PREG_SPLIT_NO_EMPTY);
        $this->allowedService->add($routes);
        $model = $this->allowedService->routeInstance();
        return Helper::filterRoutes($model->getRoutesAllowed(), false);
    }

    /**
     * Assign routes
     * @return array
     */
    public function actionAssign()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = $this->allowedService->routeInstance();
        $this->allowedService->add($routes);
        Yii::$app->getResponse()->format = 'json';
        return Helper::filterRoutes($model->getRoutesAllowed(), false);
    }

    /**
     * Remove routes
     * @return array
     */
    public function actionRemove()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = $this->allowedService->routeInstance();
        $this->allowedService->remove($routes);
        Yii::$app->getResponse()->format = 'json';
        return Helper::filterRoutes($model->getRoutesAllowed(), false);
    }

    /**
     * Refresh cache
     * @return type
     */
    public function actionRefresh()
    {
        $model = $this->allowedService->routeInstance();
        $model->invalidate();
        Yii::$app->getResponse()->format = 'json';
        return Helper::filterRoutes($model->getRoutesAllowed(), false);
    }

}
