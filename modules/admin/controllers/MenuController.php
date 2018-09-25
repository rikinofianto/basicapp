<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\form\MenuType as MenuTypeForm;
use app\modules\admin\components\Helper;
use app\modules\admin\components\BaseController;

class MenuController extends BaseController
{
    public $enableCsrfValidation = false;
    private $menuService;

    public function __construct($id, $module, $config = [])
    {
        Yii::$container->setSingleton('app\modules\admin\components\bll\IMenuService',
            'app\modules\admin\components\bll\MenuService');
        $this->menuService = Yii::$container->get('app\modules\admin\components\bll\IMenuService');

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
                // 'actions' => [
                //     'delete' => ['post'],
                // ],
            ],
        ];
    }

    /**
     * Creates a new Menu Type model.
     * If creation is successful, the browser will be redirected to the 'list-menu' page.
     * @return mixed
     */
    public function actionIndex($id = null)
    {
        $model = $this->menuService->menuTypeInstance($id);

        $post = Yii::$app->request->post('MenuType');
        if (!empty($post)) {
            $model->attributes = $post;
            if ($model->validate()) {
                if ($this->menuService->saveMenuType($model, $id)) {
                    return $this->redirect('/admin/menu');
                }
            }
        }

        $searchModel = $this->menuService->menuTypeSearchInstance();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionListMenu($id = null)
    {
        $listGroup = ArrayHelper::map($this->menuService->getAllGroup(), 'group_id', 'name');

        $post = Yii::$app->request->post('Menu');
        if (!empty($post)) {
            if ($this->menuService->saveMenu($post, $id)) {
                $this->redirect(['/admin/menu/list-menu', 'id' => $id]);
            }
        }

        $allRoutes = $this->menuService->getRoutes();
        $routes = Helper::filterRoutes($allRoutes);
        $menus = $this->menuService->getAllMenu($id);

        return $this->render('create', [
            'menus' => $menus,
            'routes' => array_merge($routes['assigned'], $routes['avaliable']),
            'menuType' => $id,
            'listGroup' => $listGroup
        ]);
    }

    public function actionDelete($id)
    {
        $this->menuService->deleteMenuType($id);
        return $this->redirect('/admin/menu');
    }
}
