<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use app\modules\admin\components\Helper;
use app\modules\admin\components\BaseController;

/**
 * Description of RuleController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class RouteController extends BaseController
{
    public $routeService;

    public function __construct($id, $module, $config = [])
    {
        Yii::$container->setSingleton('app\modules\admin\components\bll\IRouteService',
            'app\modules\admin\components\bll\RouteService');
        $this->routeService = Yii::$container->get('app\modules\admin\components\bll\IRouteService');

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
                    'refresh-allowed' => ['post'],
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
        $model = $this->routeService->instance();
        $allRoutes = $model->getRoutes();
        $routes = Helper::filterRoutes($allRoutes);
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
        $model = $this->routeService->instance();
        $model->addNew($routes);
        return Helper::filterRoutes($model->getRoutes());
    }

    /**
     * Assign routes
     * @return array
     */
    public function actionAssign()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = $this->routeService->instance();
        $model->addNew($routes);
        Yii::$app->getResponse()->format = 'json';
        return Helper::filterRoutes($model->getRoutes());
    }

    /**
     * Remove routes
     * @return array
     */
    public function actionRemove()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = $this->routeService->instance();
        $model->remove($routes);
        Yii::$app->getResponse()->format = 'json';
        return Helper::filterRoutes($model->getRoutes());
    }

    /**
     * Refresh cache
     * @return type
     */
    public function actionRefresh()
    {
        $model = $this->routeService->instance();
        $model->invalidate();
        Yii::$app->getResponse()->format = 'json';
        return Helper::filterRoutes($model->getRoutes());
    }
}
