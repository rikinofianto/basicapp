<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\DclFieldDataBody */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Dcl Field Data Body',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dcl Field Data Bodies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id, 'deleted' => $model->deleted, 'node_id' => $model->node_id, 'language' => $model->language, 'delta' => $model->delta]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="dcl-field-data-body-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
