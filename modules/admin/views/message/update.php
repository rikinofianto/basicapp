<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Message */

$this->title = Yii::t('rbac-admin', 'Update {modelClass}: ', [
    'modelClass' => 'Message',
]) . $model->message_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->message_id, 'url' => ['view', 'id' => $model->message_id]];
$this->params['breadcrumbs'][] = Yii::t('rbac-admin', 'Update');
?>
<div class="message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
