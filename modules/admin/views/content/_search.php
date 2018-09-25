<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\searchs\DclFieldDataBody */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dcl-field-data-body-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'node_type') ?>

    <?= $form->field($model, 'bundle') ?>

    <?= $form->field($model, 'deleted') ?>

    <?= $form->field($model, 'node_id') ?>

    <?php // echo $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'delta') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'body_value') ?>

    <?php // echo $form->field($model, 'body_summary') ?>

    <?php // echo $form->field($model, 'body_format') ?>

    <?php // echo $form->field($model, 'meta_tag') ?>

    <?php // echo $form->field($model, 'slideshow') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
