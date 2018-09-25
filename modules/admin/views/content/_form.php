<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\DclFieldDataBody */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dcl-field-data-body-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'node_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bundle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deleted')->textInput() ?>

    <?= $form->field($model, 'node_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delta')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body_value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'body_summary')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'body_format')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_tag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slideshow')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
