<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\modules\admin\components\Helper;
use app\modules\admin\components\BaseController;
use app\modules\admin\models\form\Message as MessageForm;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends BaseController
{
    private $messageService;
    private $countMessage;
    private static $user;

    const INBOX = 'inbox';
    const SENT  = 'sent';
    const DRAFT = 'draft';
    const TRASH = 'trash';

    public function __construct($id, $modules, $config = [])
    {
        self::$user = Helper::def(Yii::$app->user->identity, 'username');

        Yii::$container->setSingleton('app\modules\admin\components\bll\IMessageService',
            'app\modules\admin\components\bll\MessageService');
        $this->messageService = Yii::$container->get('app\modules\admin\components\bll\IMessageService');

        $user = Helper::def(Yii::$app->user->identity, 'username');
        $this->countMessage = $this->messageService->getCountMessage($user);
        parent::__construct($id, $modules, $config);
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
                    'destination' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Helper::def(Yii::$app->user->identity, 'username');
        $searchModel = $this->messageService->messageSearchInstance();
        $dataProvider = $this->messageService->setProviderInbox($searchModel);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'countMessage' => $this->countMessage,
        ]);
    }

    public function actionDraft()
    {
        $user = Helper::def(Yii::$app->user->identity, 'username');
        $searchModel = $this->messageService->messageSearchInstance();
        $dataProvider = $this->messageService->setProviderDraft($searchModel);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'countMessage' => $this->countMessage,
        ]);
    }

    public function actionSent()
    {
        $searchModel = $this->messageService->messageSearchInstance();
        $dataProvider = $this->messageService->setProviderSent($searchModel);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'countMessage' => $this->countMessage,
        ]);
    }

    public function actionTrash()
    {
        $searchModel = $this->messageService->messageBoxSearchInstance();
        $dataProvider = $this->messageService->setProviderTrash($searchModel);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'countMessage' => $this->countMessage,
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MessageForm();

        $post = Yii::$app->request->post();
        if (!empty($post)) {
            $this->messageService->createMessage($post);
        }
        return $this->render('create', [
            'model' => $model,
            'countMessage' => $this->countMessage,
        ]);
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $message = $this->loadModel('\app\modules\admin\models\Message', $id);
        $model = new MessageForm();
        $model->attributes = $message->attributes;

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect('/admin/message');
        }
        return $this->render('update', [
            'model' => $model,
            'countMessage' => $this->countMessage,
        ]);
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $user = Helper::def(Yii::$app->user->identity, 'username');
        $model = $this->loadModel('\app\modules\admin\models\Message', $id);
        $this->messageService->readMessage($id, $user);
        return $this->render('view_message', [
            'model' => $model,
            'countMessage' => $this->countMessage,
        ]);
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $type = Yii::$app->request->post('type');
            $list = Yii::$app->request->post('id');
            $list = Helper::toString(json_decode($list));
            $del = null;
            if (!empty($list)) {
                if ($type == self::DRAFT) {
                    $del = $this->messageProvider->updateAll($list);
                }
                if ($type == self::TRASH) {
                    $del = $this->messageProvider->deleteAll($list);
                }
            }
            return Helper::jsonParse($del);
        }
    }

    public function actionDeleteMessage($id)
    {
        $user = Helper::def(Yii::$app->user->identity, 'username');
        $this->messageService->setMessageDeleted($id, $user);
        return $this->redirect(['index']);
    }

    /**
     * reply message.
     * If reply is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionReply($id)
    {
        $model = new MessageForm();
        $user = Helper::def(Yii::$app->user->identity, 'username');
        $modelMessage = $this->messageService->readMessage($id, $user);
        $this->messageService->setReplyView($model, $modelMessage);
        return $this->render('reply', [
            'model' => $model,
            'countMessage' => $this->countMessage,
        ]);
    }

    public function actionForward($id)
    {
        $model = new MessageForm();
        $user = Helper::def(Yii::$app->user->identity, 'username');
        $modelMessage = $this->messageService->readMessage($id, $user);
        $this->messageService->setForwardView($model, $modelMessage);
        return $this->render('forward', [
            'model' => $model,
            'countMessage' => $this->countMessage,
        ]);

    }

    public function actionViewTrash($id)
    {
        $user = Helper::def(Yii::$app->user->identity, 'username');
        $modelMessage = $this->loadModel('\app\modules\admin\models\Message');
        $this->messageService->readMessage($id, $user);
        return $this->render('view_trash', [
            'model' => $modelMessage,
            'countMessage' => $this->countMessage,
        ]);
    }

    public function actionDeleteMessageTrash($id)
    {
        if (!empty($id)) {
            $this->messageService->deleteTrashMessage($id);
            return $this->redirect(['trash']);
        }
    }

    public function actionDestination()
    {
        if (Yii::$app->request->isAjax) {
            $type = Yii::$app->request->post('type');
            $name = Yii::$app->request->post('name');
            $data = $this->messageService->search($name, $type);
            return Helper::jsonParse($data);
        }
    }
}
