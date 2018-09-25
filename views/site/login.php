<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Login */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\admin\LoginAsset;

LoginAsset::register($this);
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-logo">
        <?= Html::encode($this->title) ?>
    </div>
  <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Please fill out the following fields to login:</p>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            // 'fieldConfig' => [
            //     'template' => "<div class=\"form-group has-feedback\">{input}</div>\n{error}",
            //     'labelOptions' => ['class' => 'col-lg-1 control-label'],
            // ],
        ]); ?>
        <div class="form-group has-feedback">
            <input type="text" name="Login[username]" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="Login[password]" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="Login['rememberMe']"> Remember Me
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
        <!-- /.col -->
        </div>
        <?php ActiveForm::end(); ?>

        <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>

    </div>
  <!-- /.login-box-body -->
    <?php if (!empty($error) && is_array($error)) : ?>
        <?php foreach ($error as $key => $value) :?>
            <div class="clearfix"></div>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                <?=$value;?>
            </div>
        <?php endforeach;?>
    <?php endif;?>
</div>