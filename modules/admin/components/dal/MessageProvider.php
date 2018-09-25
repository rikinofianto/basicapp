<?php

namespace app\modules\admin\components\dal;

use Yii;
use app\modules\admin\models\Message;
use app\modules\admin\models\MessageBox;
use app\modules\admin\models\MessageDestination;
use app\modules\admin\models\searchs\Message as MessageSearch;
use app\modules\admin\models\searchs\MessageBox as MessageBoxSearch;

class MessageProvider implements \app\modules\admin\components\dal\IMessageProvider
{
    public function messageSearchInstance()
    {
        return new MessageSearch();
    }

    public function messageBoxSearchInstance()
    {
        return new MessageBoxSearch();
    }

    public function getNewInbox($userId = null)
    {
        return Message::find()
            ->joinWith('messageIn t')
            ->andwhere(['t.receiver' => $userId])
            ->andwhere(['t.is_deleted' => '0'])
            ->andwhere(['t.is_read' => '0'])
            ->all();
    }

    public function getCountInbox($userId = null, $new = null)
    {
        $model = Message::find()
            ->joinWith('messageIn t')
            ->andwhere(['t.receiver' => $userId])
            ->andwhere(['t.is_deleted' => '0']);

        if (!empty($new))
            $model = $model->andwhere(['t.is_read' => '0']);

        return $model->count();
    }

    public function checkMessageBox($messageId = null, $receiver = null, $type = null)
    {
        return MessageBox::find()->where(['message_id' => $messageId])
            ->andwhere(['type' => $type])
            ->andwhere(['receiver' => $receiver])
            ->asArray()
            ->one();
    }

    public function getCountSent($userId = null)
    {
        return Message::find()
            ->joinWith('messageOut t')
            ->andWhere(['created_by' => $userId])
            ->andWhere(['t.is_deleted' => '0'])
            ->count();
    }

    public function getCountDraft($userId = null)
    {
        return Message::find()
            ->andWhere(['is_draft' => '1'])
            ->andWhere(['is_deleted' => '0'])
            ->andWhere(['created_by' => $userId])
            ->count();
    }

    public function getCountTrash($userId = null)
    {
        return MessageBox::find()
            ->joinWith('message t')
            ->andWhere([MessageBox::tableName() . '.is_deleted' => '1'])
            ->andWhere(['t.is_deleted' => '0'])
            ->andWhere(['receiver' => $userId])
            ->count();
    }

    public function getMessageById($messageId = null)
    {
        return Message::findOne($messageId);
    }

    public function readMessage($messageId = null, $receiver = null)
    {
        $messageBox = MessageBox::find()->where(['message_id' => $messageId])
            ->andwhere(['type' => 'in'])
            ->andwhere(['receiver' => $receiver])
            ->one();

        if (!empty($messageBox)) {
            if ($messageBox->is_read == 0) {
                $messageBox->is_read = 1;
                return $messageBox->save();
            }
        }
        return false;
    }

    public function setMessageDeleted($messageId = null, $receiver = null)
    {
        try {
            $mesasgeBox = MessageBox::find()->where(['message_id' => $messageId])
                ->andwhere(['type' => 'in'])
                ->andwhere(['receiver' => $receiver])
                ->one();
            $mesasgeBox->is_deleted ='1';

            return $mesasgeBox->save();
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
        }
    }

    public function saveMessageDestination($messageId = null, $destinationType = null, $destination = null)
    {
        $messageDestination = new MessageDestination;
        $messageDestination->message_id = $messageId;
        $messageDestination->destination_type = $destinationType;
        $messageDestination->destination = $destination;
        return $messageDestination->save();
    }

    public function sendMessage($messageId = null, $sender = null, $receiver = null, $checkOutMessage = null, $checkInMessage = null)
    {
        if (empty($checkOutMessage)) {
            $messageBoxOut = new MessageBox;
            $messageBoxOut->message_id = $messageId;
            $messageBoxOut->type = 'out';
            $messageBoxOut->receiver = $sender;
            $messageBoxOut->save();
        }

        if (empty($checkInMessage)) {
            $messageBoxIn = new MessageBox;
            $messageBoxIn->message_id = $messageId;
            $messageBoxIn->type = 'in';
            $messageBoxIn->receiver = $receiver;
            $messageBoxIn->save();
        }
    }

    public function saveMessage($subject = null, $messageDetail = null, $draft = null, $createdBy = null)
    {
        $model = new Message;
        $model->subject = $subject;
        $model->message = $messageDetail;
        $model->is_draft =  $draft;
        $model->created_by = $createdBy;
        if($model->save())
            return $model->message_id;
    }

    public function setProviderTrash($searchModel, $user)
    {
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith('message t');
        $dataProvider->query->andWhere([MessageBox::tableName() . '.is_deleted' => '1']);
        $dataProvider->query->andWhere(['t.is_deleted' => '0']);
        $dataProvider->query->andWhere(['receiver' => $user]);
        return $dataProvider;
    }

    public function setProviderSent($searchModel, $user)
    {
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith('messageOut t');
        $dataProvider->query->andWhere(['created_by' => $user]);
        $dataProvider->query->andWhere(['t.is_deleted' => '0']);
        return $dataProvider;
    }

    public function setProviderDraft($searchModel, $user)
    {
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['is_draft' => '1']);
        $dataProvider->query->andWhere(['is_deleted' => '0']);
        $dataProvider->query->andWhere(['created_by' => $user]);
        return $dataProvider;
    }

    public function setProviderInbox($searchModel, $user)
    {
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith('messageIn t');
        $dataProvider->query->andWhere(['t.is_deleted' => '0']);
        $dataProvider->query->andWhere(['t.receiver' => $user]);
        return $dataProvider;
    }

    public function deleteTrashMessage($messageId = null)
    {
        $model = Message::findOne($messageId);
        $model->is_deleted = '1';
        return $model->save();
    }

    public function updateAll($list)
    {
        return Message::updateAll(['is_deleted' => '1'], 'message_id in :list', [':list' => $list]);
    }

    public function deleteAll($list)
    {
        return Message::deleteAll('message_id in :list', [':list' => $list]);
    }

}
