<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\searchs\DclMedia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-xs-7 admin-form theme-primary">
    <div class="mix-controls ib col-xs-12"> 

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>



        <div class="row">
            <div class="smart-widget sm-right smr-50">
                <?= $form->field($model, 'name', [
                'template' => "<label class='field'>{input}</label>\n{hint}\n{error}"])->textInput(['maxlength' => true, 'placeholder' => 'Search','class'=>'gui-input'])?>
                <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'button btn-primary']) ?>
            </div>
            <!-- end .smart-widget section -->
        </div>

    <?php ActiveForm::end(); ?>

    </div>
</div>



