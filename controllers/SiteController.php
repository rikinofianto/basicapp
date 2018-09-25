<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\modules\admin\models\form\Login;
use app\models\ContactForm;

class SiteController extends Controller
{
    private $userService;

    public function __construct($id, $module, $config = [])
    {
        Yii::$container->setSingleton('app\modules\admin\components\bll\IUserService',
            'app\modules\admin\components\bll\UserService');
        $this->userService = Yii::$container->get('app\modules\admin\components\bll\IUserService');

        parent::__construct($id, $module, $config);
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = '@app/views/layouts/login.php';
        $model = new Login();

        $post = Yii::$app->request->post('Login');
        $err = [];
        if (!empty($post)) {
            $model->attributes = $post;
            if ($model->validate() && $this->userService->login($model)) {
                $userId = Yii::$app->user->getId();
                $url = $this->userService->getRedirectUrl($userId);
                // redirect to default url
                if (!empty(reset($url))) {
                    return $this->redirect([reset($url)]);
                }
                return $this->goBack();
            } else {
                foreach ($model->getErrors() as $key => $value) {
                    $err[$key] = implode(', ', $value);
                }
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
            'error' => $err
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
