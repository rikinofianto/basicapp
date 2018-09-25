<?php

namespace app\modules\admin\components\bll;

interface IMessageService
{
    public function messageSearchInstance();
    public function messageBoxSearchInstance();
    public function getCountMessage($userId);
    public function getCountInbox($userId = null, $new = null);
    public function checkMessageBox($messageId = null, $receiver = null, $type = null);
    public function getMessageById($messageId = null);
    public function readMessage($messageId = null, $receiver = null);
    public function setMessageDeleted($messageId = null, $receiver = null);
    public function createMessage($post = nulll);
    public function setForwardView(&$messageForm, $modelMessage);
    public function setReplyView(&$messageForm, $modelMessage);
    public function setProviderSent($searchModel);
    public function setProviderTrash($searchModel);
    public function setProviderDraft($searchModel);
    public function setProviderInbox($searchModel);
    public function deleteTrashMessage($messageId = null);
    public function updateAll($list);
    public function deleteAll($list);
}
