<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\DclMedia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dcl-media-form col-sm-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder' => Yii::t('app', 'Insert Name')]) ?>

    <?= $form->field($model, 'desc')->textarea(['maxlength' => true,'placeholder' => Yii::t('app', 'Insert Description')]) ?>

    <?= $form->field($model, 'position')->dropDownList([ 'no-position' => 'No-position', 'top' => 'Top', 'left' => 'Left', 'right' => 'Right', 'bottom' => 'Bottom', ]) ?>
    
    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'type')->dropDownList([ 0 => 'Images', 1 => 'Video' ]) ?>
    <?php endif ?>

    <?php // $form->field($model, 'type')->textInput() ?>
    
<!-- <?php // $form->field($model, 'created')->textInput() ?>

    <?php // $form->field($model, 'updated')->textInput() ?>


    <?php // $form->field($model, 'setting')->textarea(['rows' => 6]) ?>

    <?php // $form->field($model, 'path_name')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'create_by')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'privilege')->textarea(['rows' => 6]) ?>


    <?php // $form->field($model, 'size')->textarea(['rows' => 6]) ?>


    <?php // $form->field($model, 'group')->textInput(['maxlength' => true]) ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
