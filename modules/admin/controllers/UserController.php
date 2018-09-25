<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\Helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\mail\BaseMailer;
use app\modules\admin\models\form\Login;
use app\modules\admin\models\form\PasswordResetRequest;
use app\modules\admin\models\form\ResetPassword;
use app\modules\admin\models\form\Signup;
use app\modules\admin\models\form\ChangePassword;
use app\modules\admin\models\form\CreateUser;
use app\modules\admin\models\form\User as UserForm;
use app\modules\admin\components\BaseController;

/**
 * User controller
 */
class UserController extends BaseController
{
    private $_oldMailPath;
    private $groupService;
    private $userService;

    public function __construct($id, $module, $config = [])
    {
        Yii::$container->setSingleton('app\modules\admin\components\bll\IUserService',
            'app\modules\admin\components\bll\UserService');
        $this->userService = Yii::$container->get('app\modules\admin\components\bll\IUserService');

        parent::__construct($id, $module, $config);
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            /*
            'access' => [
               'class' => AccessControl::className(),
               'rules' => [
                   [
                       'actions' => ['signup', 'reset-password', 'login', 'request-password-reset'],
                       'allow' => true,
                       'roles' => ['?'],
                   ],
                   [
                       'actions' => ['logout', 'change-password', 'index', 'view', 'delete', 'activate'],
                       'allow' => true,
                       'roles' => ['@'],
                   ],
               ],
            ],
            */
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'logout' => ['post'],
                    'activate' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (Yii::$app->has('mailer') && ($mailer = Yii::$app->getMailer()) instanceof BaseMailer) {
                /* @var $mailer BaseMailer */
                $this->_oldMailPath = $mailer->getViewPath();
                $mailer->setViewPath('@app/modules/admin/mail');
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if ($this->_oldMailPath !== null) {
            Yii::$app->getMailer()->setViewPath($this->_oldMailPath);
        }
        return parent::afterAction($action, $result);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = $this->userService->userSearchInstance();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Update User & user Group.
     * @param integer $id
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateUser();
        $groups = $this->userService->getAllGroup();
        $listGroup = ArrayHelper::map($groups, 'group_id', 'name');

        $post = Yii::$app->getRequest()->post('CreateUser');
        if (!empty($post)) {
            $model->attributes = $post;
            if ($model->validate()) {
                if ($this->userService->createAllUserGroup($post, $model)) {
                    return $this->redirect(['index']);
                } else {
                    $model->addError('email', Yii::t('rbac-admin', 'This email address has already been taken.'));
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'listGroup' => $listGroup
        ]);
    }

    /**
     * Update User & user Group.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = $this->loadModel('\app\modules\admin\models\User', $id);
        $model = new UserForm();
        $groups = $this->userService->getAllGroup();
        $listGroup = ArrayHelper::map($groups, 'group_id', 'name');
        $model->attributes = $user->attributes;
        $model->group_id = $this->userService->setGroup($user);

        $post = Yii::$app->getRequest()->post('User');
        if (!empty($post)) {
            $model->attributes = $user->attributes = $post;
            if ($model->validate() && $user->validate()) {
                if ($user->save()) {
                    $this->userService->updateAllUserGroup($post, $user->id);
                    return $this->redirect(['index']);
                } else {
                    $model->addError('email', Yii::t('rbac-admin', 'This email address has already been taken.'));
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'listGroup' => $listGroup
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->loadModel('\app\modules\admin\models\User', $id),
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->loadModel('\app\modules\admin\models\User', $id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Login
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }

        //Set session jika kosong
        if (Yii::$app->session->get('failattempts') == null) {
            Yii::$app->session['failattempts'] = 0;
        }
        $failattempts = Yii::$app->session->get('failattempts');

        $model = new Login();
        if($failattempts >= 3) {
            $model->scenario = 'failthreetimes';
        } // Set scenario if fail more than three times

        $post = Yii::$app->request->post('Login');
        if (!empty($post)) {
            $model->attributes = $post;
            if ($model->validate() && $this->userService->login($model)) {
                $userId = Yii::$app->user->getId();
                $url = $this->userService->getRedirectUrl($userId);
                Yii::$app->session['failattempts'] = 0;
                // redirect to default url
                if (!empty(reset($url))) {
                    return $this->redirect([reset($url)]);
                }
                return $this->goBack();
            }
            else
            {
                Yii::$app->session['failattempts'] = $failattempts + 1 ;
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();

        return $this->goHome();
    }

    /**
     * Signup new user
     *
     * @return string
     */
    public function actionSignup()
    {
        $model = new Signup();
        $post = Yii::$app->request->post('Signup');
        if (!empty($post)) {
            $model->attributes = $post;
            if ($model->validate()) {
                if ($this->userService->createUser($model)) {
                    Yii::$app->getSession()->setFlash('success', 'Registrasi berhasil');
                } else {
                    Yii::$app->getSession()->setFlash('fail', 'Registrasi gagal');
                }
                return $this->redirect('/admin/user/signup');
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Request reset password
     * @return string
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequest();
        $model->scenario = 'reCaptchaOn';
        $post = Yii::$app->request->post('PasswordResetRequest');
        if (!empty($post)) {
            $model->attributes = $post;
            if ($model->validate()) {
                if ($this->userService->sendEmail($model->email)) {
                    Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                    return $this->goHome();
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
                }
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Reset password
     * @return string
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $post = Yii::$app->request->post('ResetPassword');

   
        $time_request = end(split('_',$token));
        $limit = strtotime("+30 minutes", $time_request);
        $now = time();
        // echo date( "Y-m-d H:i:s", $limit ) .' '.date( "Y-m-d H:i:s", $time_request ).' '.date( "Y-m-d H:i:s", $now );die;

        if ($now > $limit) {
            Yii::$app->getSession()->setFlash('danger', 'Request token has expired, please request a new one.');
            return $this->goHome();
        }

        if (!empty($post)) {
            $model->attributes = $post;
            if ($model->validate() && $this->userService->resetPassword($model->password)) {
                Yii::$app->getSession()->setFlash('success', 'New password was saved.');

                return $this->goHome();
            }
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Reset password
     * @return string
     */
    public function actionChangePassword()
    {
        $model = new ChangePassword();
        $post = Yii::$app->request->post('ChangePassword');
        if (!empty($post)) {
            $model->attributes = $post;
            if ($model->validate() && $this->userService->changePassword($model)) {
                return $this->goHome();
            }
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    /**
     * Activate new user
     * @param integer $id
     * @return type
     * @throws UserException
     * @throws NotFoundHttpException
     */
    public function actionActivate($id)
    {
        /* @var $user User */
        $user = $this->loadModel('\app\modules\admin\models\User', $id);
        if ($user->status == User::STATUS_INACTIVE) {
            $user->status = User::STATUS_ACTIVE;
            if ($user->save()) {
                return $this->goHome();
            } else {
                $errors = $user->firstErrors;
                throw new UserException(reset($errors));
            }
        }
        return $this->goHome();
    }

    /**
     * [actionProfileUser description]
     * @return [type] [description]
     */
    public function actionProfileUser()
    {
        $id = Yii::$app->user->id;
        return $this->render('profile-user', [
            'model' => $this->loadModel('\app\modules\admin\models\User', $id),
            ]);
    }

    /**
     * [actionSettingProfile description]
     * @return [type] [description]
     */
    public function actionSettingProfile()
    {
        $id = Yii::$app->user->id;
        $model = $this->loadModel('\app\modules\admin\models\User', $id);
        
        $post = Yii::$app->getRequest()->post('User');
        if (!empty($post)) {
            $model->attributes = $post;
            if ($model->validate() && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('yii', 'Berhasil disimpan') );
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('danger', Yii::t('yii', 'Gagal disimpan') );
            }
            
        }

        return $this->render('setting-profile', [
            'model' => $model,
            'listGroup' => $listGroup
        ]);
    }
}
