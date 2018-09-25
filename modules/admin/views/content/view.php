<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\DclFieldDataBody */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dcl Field Data Bodies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dcl-field-data-body-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id, 'deleted' => $model->deleted, 'node_id' => $model->node_id, 'language' => $model->language, 'delta' => $model->delta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id, 'deleted' => $model->deleted, 'node_id' => $model->node_id, 'language' => $model->language, 'delta' => $model->delta], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'node_type',
            'bundle',
            'deleted',
            'node_id',
            'language',
            'delta',
            'title',
            'body_value:html',
            'body_summary:ntext',
            'body_format',
            'meta_tag',
            'slideshow:ntext',
        ],
    ]) ?>

</div>
