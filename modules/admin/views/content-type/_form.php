<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\DclNodeType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dcl-node-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'node_type')->textInput(['maxlength' => true]) ?>
    <?php // $form->field($model, 'module')->textInput(['maxlength' => true]) ?>
    <?php // $form->field($model, 'description')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder' => Yii::t('app', 'Insert Name')]) ?>


    <?= $form->field($model, 'description')->textarea(['maxlength' => true,'placeholder' => Yii::t('app', 'Insert Description')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
