<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\DclNodeType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Fields',
]) . $model->field_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manage Fields'), 'url' => ['manage-fields', 'id' => $model->node_type]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="dcl-node-type-update">

    <div class="panel">
        <div class="panel-heading">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
            <?= $this->render('_form-fields', [
                'model' => $model,
                ]) ?>

        </div>

    </div>

</div>
