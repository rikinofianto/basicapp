<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Message */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="panel">
    <div class="panel-body">
        <div class="message-view">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'message_id',
                    'subject',
                    'message:ntext',
                    'created_by',
                    'created_at',
                ],
            ]) ?>
        </div>
    </div>
</section>
