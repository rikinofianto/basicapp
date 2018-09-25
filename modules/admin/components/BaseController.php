<?php

namespace app\modules\admin\components;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class BaseController extends Controller
{
    public $menu = [];
    public $menuType = 'backend-menu';
    private $menuService;

    public function __construct($id, $module, $config = [])
    {
        Yii::$container->setSingleton('app\modules\admin\components\bll\IMenuLayoutService',
            'app\modules\admin\components\bll\MenuService');
        $this->menuService = Yii::$container->get('app\modules\admin\components\bll\IMenuLayoutService');

        parent::__construct($id, $module, $config);
    }

    public static function loadModel($modelName, $id)
    {
        $model = $modelName::findOne($id);
        if ($model === null)
            throw new HttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function beforeAction($action)
    {
        $this->initMenu();

        if (!parent::beforeAction($action)) {
            return false;
        }
        return true;
    }

    public function initMenu()
    {
        if (!Yii::$app->user->isGuest) {
            $session = Yii::$app->getSession();

            if (empty($session->get('menu'))) {
                $menu = $this->menuService->getMenuCache($this->menuType);
                $session->set('menu', $menu);
            }
            Yii::$app->view->params['menu'] = $session->get('menu');
        }
    }

}
