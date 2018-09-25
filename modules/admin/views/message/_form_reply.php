<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.delete-dest {
    line-height: 0.1;
    /* Other styles.. */
}
</style>
<div class="message-form">

    <?php $form = ActiveForm::begin(['action' =>['/admin/message/create'], 'method' => 'post',]); ?>

    <?php echo $form->field($model, 'destination_type')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'destination')->textInput(['maxlength' => true]) ?>

    <div class="form-group list-destination">
        <div>
            <div class="label label-warning"><?= $model->destination ?></div>
                <button type='button' class='btn btn-danger delete-dest'>x</button>
                <input type='hidden' id='message-destination' name='Message[destination][user][1]' value = <?= $model->destination?>>
        </div>
    </div>

    <?php echo $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?php echo Html::submitButton(empty($model->message_id) ? Yii::t('rbac-admin', 'Create') :
            Yii::t('rbac-admin', 'Update'), ['class' =>empty($model->message_id) ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button type="submit" class="btn btn-primary" name="Message[send_message]" value="send_message">
        <i class="fa fa-envelope-o"></i> Send
        </button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
