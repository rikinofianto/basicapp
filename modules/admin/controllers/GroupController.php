<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\Route;
use app\modules\admin\components\Helper;
use app\modules\admin\components\BaseController;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends BaseController
{
    private $groupService;

    public function __construct($id, $module, $config = [])
    {
        Yii::$container->setSingleton('app\modules\admin\components\bll\IGroupService',
            'app\modules\admin\components\bll\GroupService');
        $this->groupService = Yii::$container->get('app\modules\admin\components\bll\IGroupService');

        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = $this->groupService->groupSearchInstance();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->loadModel('\app\modules\admin\models\Group', $id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = $this->groupService->groupInstance();

        $parent = ArrayHelper::map($model->getOption($model),'group_id','name');
        $route = $this->groupService->getSavedRoutes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'parent' => $parent,
            'route' => $route,
        ]);
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel('\app\modules\admin\models\Group', $id);

        $parent = ArrayHelper::map($model->getOption($model),'group_id','name');
        $route = $this->groupService->getSavedRoutes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'parent' => $parent,
            'route' => $route,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel('\app\modules\admin\models\Group', $id);

        if ($model->delete()) {
            return $this->redirect(['index']);
        }
    }

}
