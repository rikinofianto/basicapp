<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\DclMedia */

$this->title = Yii::t('app', 'Update {modelClass}: ', ['modelClass' => 'Media',]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->media_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="dcl-media-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
