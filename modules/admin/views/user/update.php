<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\admin\models\form\Signup */

$this->title = Yii::t('rbac-admin', 'Update');
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="panel">
    <div class="panel-body">
        <div class="user-update">
            <!-- <h1><?= Html::encode($this->title) ?></h1> -->

            <?php echo Html::errorSummary($model)?>
            <div class="row">
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-update-user',
                        // 'enableAjaxValidation' => true
                    ]); ?>
                        <?php echo $form->field($model, 'username')->textInput() ?>
                        <?php echo $form->field($model, 'email')->textInput() ?>
                        <?php echo $form->field($model, 'group_id')->checkBoxList($listGroup) ?>
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('rbac-admin', 'Update'), ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
