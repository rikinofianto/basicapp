<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use app\modules\admin\models\Menu;
use app\modules\admin\AutocompleteAsset;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
            <?php echo $form->field($model, 'title')->textInput(['maxlength' => 50]) ?>
            <?php echo $form->field($model, 'description')->textarea(['rows' => 4]) ?>
            <?php
                echo Html::submitButton(
                    empty($model->menu_type) ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'update'),
                    ['class' => empty($model->menu_type) ? 'btn btn-success' : 'btn btn-primary'])
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
