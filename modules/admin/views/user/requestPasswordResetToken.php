<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */ 
/* @var $form yii\bootstrap\ActiveForm */ 
/* @var $model \app\modules\admin\models\form\PasswordResetRequest */ 

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="admin-form theme-info mw500" style="margin-top: 10%;" id="login">
  <div class="row mb15 table-layout">

	<div class="col-xs-6 pln">
	  <!--<a href="dashboard.html" title="Return to Dashboard"> -->
		<h1><?= Html::encode(Yii::$app->name) ?></h1>
		<!--<img src="assets/img/logos/logo.png" title="AdminDesigns Logo" class="img-responsive w250"> -->
	  <!-- </a> -->
	</div>

	<div class="col-xs-6 va-b">
	  <div class="login-links text-right">
		<a href="#" class="" title="False Credentials"><?= Html::encode($this->title) ?></a>
	  </div>
	</div>
  </div>

  <div class="panel">

	<!-- <form method="post" action="/" id="contact"> -->
	<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
	  <div class="panel-body p15">

		<div class="alert alert-micro alert-border-left alert-info pastel alert-dismissable mn">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		  <i class="fa fa-info pr10"></i> Enter your
		  <b>Email</b> and instructions will be sent to you!
		</div>

	  </div>
	  <!-- end .form-body section -->
	  <div class="panel-footer p25 pv15">

		<div class="section mn">

		  <div class="smart-widget sm-right">
			
			<label for="email" class="field prepend-icon">
			<?= $form->field($model, 'email', [
				  'template' => "
				  <label for=\"email\" class=\"field prepend-icon\">
				  {input}
					<label for=\"email\" class=\"field-icon\">
					  <i class=\"fa fa-envelope-o\"></i>
					</label>
					</label>
					<button type=\"submit\" for=\"email\" class=\"button\">Reset</button>
					\n{hint}\n{error}",
				])->textInput(['maxlength' => true,'id' => "email"])->input('email', ['placeholder' => "Enter Your Email",'class'=>'gui-input'])->label(false) ?>
			</label>
		  
			<?= $form->field($model, 'reCaptcha')->widget(\app\modules\admin\widget\recaptcha\ReCaptcha::className()) ?>    
			<!-- <label for="email" class="field prepend-icon">
			  <input type="text" name="email" id="email" class="gui-input" placeholder="Your Email Address">
			  <label for="email" class="field-icon">
				<i class="fa fa-envelope-o"></i>
			  </label>
			</label> -->
			
			
			<!-- <label for="email" class="button">Reset</label> -->
		  </div>
		  <!-- end .smart-widget section -->

		</div>
		<!-- end section -->

	  </div>
	  <!-- end .form-footer section -->

	<!-- </form> -->
	<?php ActiveForm::end(); ?>

  </div>

</div>





