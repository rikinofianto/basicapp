<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="admin-form theme-info mw500" id="login">

  <!-- Login Logo -->
  <div class="row table-layout">
    <div class="col-sm-12 text-center">
        <h1><?= Html::encode(Yii::$app->name) ?></h1>
        
    </div>
  </div>

  <!-- Login Panel/Form -->
  <div class="panel mt30 mb25">

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
      <div class="panel-body bg-light p25 pb15">

        <!-- Username Input -->
        <div class="section">

          <?= $form->field($model, 'username', [
              'template' => "{label}\n<label class='field prepend-icon'>{input}
                <label for=\"username\" class=\"field-icon\">
                  <i class=\"fa fa-user\"></i>
                </label>
            </label>\n{hint}\n{error}",
              'labelOptions' => [ 'class' => 'field-label text-muted fs18 mb10' ]
            ])->textInput(['maxlength' => true, 'placeholder' => 'Enter username'])?>

        </div>

        <!-- Password Input -->
        <div class="section">

          <?= $form->field($model, 'password', [
              'template' => "{label}\n<label class='field prepend-icon'>{input}
                <label for=\"password\" class=\"field-icon\">
                  <i class=\"fa fa-lock\"></i>
                </label>
            </label>\n{hint}\n{error}",
              'labelOptions' => [ 'class' => 'field-label text-muted fs18 mb10' ]
            ])->passwordInput(['class' => "gui-input",'placeholder' => 'Enter password'])?>


        </div>

        <div class="section">    
        <?php
          if (Yii::$app->session->get('failattempts') >= 3) {
            echo $form->field($model, 'reCaptcha')->widget(\app\modules\admin\widget\recaptcha\ReCaptcha::className()) ;
          }
          ?>       
      
        </div>
      </div>

      <div class="panel-footer clearfix">

        <?= Html::submitButton('Sign In', ['class' => 'button btn-primary mr10 pull-right', 'name' => 'login-button']) ?>
          

        <?= $form->field($model, 'rememberMe', [
          'template' => "<label class=\"switch ib switch-primary mt10\">
                          {input}
                          <label for=\"remember\" data-on=\"YES\" data-off=\"NO\"></label>
                          <span>{label}</span>
                        </label>\n
                        <div class=\"col-lg-8\">{error}</div>",
                        'labelOptions' => [ 'class' => '' ]
          ])->checkbox(['id'=>'remember'],false) ?>

      </div>

    <!-- </form> -->
    <?php ActiveForm::end(); ?>



    
  </div>

  <!-- Registration Links -->
  <div class="login-links">
    <p>
      <?php echo Html::a('Forgot Password?', Yii::$app->urlManager->createUrl('admin/user/request-password-reset'),['class'=>'active']) ?>
    </p>

  </div>



</div>





