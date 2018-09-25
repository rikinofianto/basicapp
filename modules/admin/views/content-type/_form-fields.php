<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\DclNodeType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dcl-node-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'field_name')->textInput( !$model->isNewRecord ? ['disabled' => 'disabled' , 'maxlength' => true] : ['maxlength' => true] ) ?>

    <?php // $form->field($model, 'type')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'type')->dropDownList(['file' => 'File', 'short_text' => 'Short Text', 'long_text' => 'Long Text'], !$model->isNewRecord ? ['disabled' => 'disabled' , 'class'=>'form-control istype'] : ['class'=>'form-control istype'] ); ?>

    <div class="istype-file" hidden="hidden">
        <?= $form->field($model, 'data')->textInput(['placeholder' => Yii::t('app','Allowed Types') ])->label(false) ?>
    </div>
    
    <?= $form->field($model, 'required')->checkBox(['class'=>'isrequired']) ?>

    <div class="isrequired-checked" hidden="hidden">
        <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>
    </div>

    <?= $form->field($model, 'active')->checkBox() ?>

    <?php // $form->field($model, 'timestamp')->textInput() ?>
    
    <?php // $form->field($model, 'node_type')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder' => Yii::t('app', 'Insert Name')]) ?>

    <?php // $form->field($model, 'description')->textarea(['maxlength' => true,'placeholder' => Yii::t('app', 'Insert Description')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php 

$script = <<< JS

checkMessage();
checkData();

$('.isrequired').change(function() {
    checkMessage();
});

$('.istype').change(function() {
    checkData();
});


function checkMessage(){
    if ( $('.isrequired').is(':checked') ) {
        $('.isrequired-checked').show();
    }
    else{
        $('.isrequired-checked').hide();
    }
}

function checkData(){
    if ( $('.istype').val() == 'file' ) {
        $('.istype-file').show();
    }
    else{
        $('.istype-file').hide();
    }
}



JS;


$this->registerJS($script);
 ?>