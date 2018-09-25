<?php

namespace app\modules\admin\components\dal;

interface IMessageProvider
{
    public function messageSearchInstance();
    public function messageBoxSearchInstance();
    public function getNewInbox($userId = null);
    public function getCountInbox($userId = null, $new = null);
    public function checkMessageBox($messageId = null, $receiver = null, $type = null);
    public function getCountSent($userId = null);
    public function getCountDraft($userId = null);
    public function getCountTrash($userId = null);
    public function getMessageById($messageId = null);
    public function readMessage($messageId = null, $receiver = null);
    public function setMessageDeleted($messageId = null, $receiver = null);
    public function saveMessage($subject = null, $messageDetail = null, $draft = null, $createdBy = null);
    public function sendMessage($messageId = null, $sender = null, $receiver = null, $checkOutMessage = null, $checkInMessage = null);
    public function saveMessageDestination($messageId = null, $destination_type = null, $destination = null);
    public function setProviderTrash($searchModel, $user);
    public function setProviderSent($searchModel, $user);
    public function setProviderDraft($searchModel, $user);
    public function setProviderInbox($searchModel, $user);
    public function deleteTrashMessage($messageId = null);
    public function updateAll($list);
    public function deleteAll($list);
}
