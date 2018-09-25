<?php

namespace app\modules\admin\components\bll;

use Yii;
use yii\helpers\Url;
use app\modules\admin\components\Helper;

class MessageService implements IMessageService
{
    private $messageProvider;
    private $userGroupProvider;
    private $userProvider;
    private $groupProvider;
    private static $messageType = ['group', 'user'];
    private static $user;

    public function __construct() {
        self::$user = Helper::def(Yii::$app->user->identity, 'username');
        $container = Yii::$container;

        $container->setSingleton('app\modules\admin\components\dal\IMessageProvider',
            'app\modules\admin\components\dal\MessageProvider');
        $this->messageProvider = $container->get('app\modules\admin\components\dal\IMessageProvider');

        $container->setSingleton('app\modules\admin\components\dal\IMessageUserGroupProvider',
            'app\modules\admin\components\dal\UserGroupProvider');
        $this->userGroupProvider = $container->get('app\modules\admin\components\dal\IMessageUserGroupProvider');

        $container->setSingleton('app\modules\admin\components\dal\IMessageUserProvider',
            'app\modules\admin\components\dal\UserProvider');
        $this->userProvider = $container->get('app\modules\admin\components\dal\IMessageUserProvider');

        $container->setSingleton('app\modules\admin\components\dal\IMessageGroupProvider',
            'app\modules\admin\components\dal\GroupProvider');
        $this->groupProvider = $container->get('app\modules\admin\components\dal\IMessageGroupProvider');
    }

    public function messageSearchInstance()
    {
        return $this->messageProvider->messageSearchInstance();
    }

    public function messageBoxSearchInstance()
    {
        return $this->messageProvider->messageBoxSearchInstance();
    }

    public function getCountMessage($userId)
    {
        $countTrash = $this->messageProvider->getCountTrash($userId);
        $countSent = $this->messageProvider->getCountSent($userId);
        $countDraft = $this->messageProvider->getCountDraft($userId);
        $countInbox = self::getCountInbox($userId);
        $countNewInbox = self::getCountInbox($userId, 'new');
        return [
            'count_trash' => $countTrash,
            'count_sent' => $countSent,
            'count_draft' => $countDraft,
            'count_inbox' => $countInbox,
            'count_new_inbox' => $countNewInbox,
        ];
    }

    public function getCountInbox($userId = null, $new = null)
    {
        return $this->messageProvider->getCountInbox($userId, $new);
    }

    public function checkMessageBox($messageId = null, $receiver = null, $type = null)
    {
        return $this->messageProvider->checkMessageBox($messageId, $receiver, $type);
    }

    public function getMessageById($messageId = null)
    {
        return $this->messageProvider->getMessageById($messageId);
    }

    public function readMessage($messageId = null, $receiver = null)
    {
        return $this->messageProvider->readMessage($messageId, $receiver);
    }

    public function setMessageDeleted($messageId = null, $receiver = null)
    {
        return $this->messageProvider->setMessageDeleted($messageId, $receiver);
    }

    public function createMessage($post = null)
    {
        $message = Helper::def($post, 'Message');
        $destination = Helper::def($message, 'destination');
        $messageDetail = Helper::def($message, 'message');
        $subject = Helper::def($message, 'subject');
        $draft = (!empty(Helper::def($message, 'send_message'))) ? '0' : '1';
        $messageId = $this->messageProvider->saveMessage(
            $subject,
            $messageDetail,
            $draft,
            self::$user
        );
        $destination_arrays = array_keys($destination);
        foreach (self::$messageType as $type) {
            if (array_key_exists($type, $destination)) {
                $destinationMessage = Helper::def($destination, $type);
                foreach ($destinationMessage as $key => $value) {
                    $this->messageProvider->saveMessageDestination($messageId, $type, $value);
                    if ($draft == '0') {
                        if ($type == 'group') {
                            $users = $this->userGroupProvider->findByGroupId($value);
                            foreach($users as $user) {
                                $receiver = Helper::def($user->user, 'username');
                                $checkOutMessage = self::checkMessageBox($messageId, $sender, 'out');
                                $checkInMessage = self::checkMessageBox($messageId, $sender, 'in');
                                $this->messageProvider->sendMessage($messageId, self::$user, $receiver, $checkOutMessage, $checkInMessage);
                            }
                        } else {
                            $this->messageProvider->sendMessage($messageId, self::$user, $value);
                        }
                    }
                }
            }
        }
        return Yii::$app->response->redirect(Url::to(['message/index']));
    }

    public function setForwardView(&$messageForm, $modelMessage)
    {
        $messageForm->destination_type = "user";
        $messageForm->destination = $modelMessage->messageOut->receiver;
        $messageForm->subject ="Forward:".$modelMessage->subject;
        $messageForm->message = $modelMessage->message;
    }

    public function setReplyView(&$messageForm, $modelMessage)
    {
        $messageForm->destination_type = "user";
        $messageForm->destination = $modelMessage->messageOut->receiver;
        $messageForm->subject ="RE:".$modelMessage->subject;
    }

    public function setProviderSent($searchModel)
    {
        return $this->messageProvider->setProviderSent($searchModel, self::$user);
    }

    public function setProviderTrash($searchModel)
    {
        return $this->messageProvider->setProviderTrash($searchModel, self::$user);
    }

    public function setProviderDraft($searchModel)
    {
        return $this->messageProvider->setProviderDraft($searchModel, self::$user);
    }

    public function setProviderInbox($searchModel)
    {
        return $this->messageProvider->setProviderInbox($searchModel, self::$user);
    }

    public function deleteTrashMessage($messageId = null)
    {
        return $this->messageProvider->deleteTrashMessage($messageId);
    }

    public function updateAll($list)
    {
        if (!empty($list)) {
            return $this->messageProvider->updateAll($list);
        }
        return false;
    }

    public function deleteAll($list)
    {
        if (!empty($list)) {
            return $this->messageProvider->deleteAll($list);
        }
        return false;
    }

    public function search($name = null, $type = null)
    {
        $models = [];
        if ($type == 'user') {
            $models = $this->userProvider->searchUser($name);
        }
        if ($type == 'group') {
            $models = $this->groupProvider->searchGroup($name);
        }
        return self::setArrAutocomplete($models, $type);
    }

    protected static function setArrAutocomplete($models, $type)
    {
        $data = [];
        if (!empty($models) && !empty($type)) {
            $i = 0;
            foreach ($models as $key => $model) {
                if ($type == 'user') {
                    $data[$i]['id'] = $model->id;
                    $data[$i]['type'] = $type;
                    $data[$i]['label'] = $model->username;
                }
                if ($type == 'group') {
                    $data[$i]['id'] = $model->group_id;
                    $data[$i]['type'] = $type;
                    $data[$i]['label'] = $model->name;
                }
                $i++;
            }
        }
        return $data;
    }
}