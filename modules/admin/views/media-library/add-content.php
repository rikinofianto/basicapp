<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\DclMedia */

$this->title = Yii::t('app', 'Add Media');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Media Content'), 'url' => ['view','id'=>$model->media_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

  <style>
  /*dropzone demo css*/
  .dz-demo .dz-message {
    opacity: 0 !important;
  }
  .dropzone .dz-preview.example-preview .dz-success-mark,
  .dropzone-previews .dz-preview.example-preview .dz-success-mark {
    opacity: 1;
  }
  .dropzone .dz-preview.example-preview .dz-error-mark,
  .dropzone-previews .dz-preview.example-preview .dz-error-mark {
    opacity: 0;
  }
  </style>

<div class="row">
	<div class="col-sm-12 pl30 pr30">
		<div class="tray-bin pl10 mb10">
			<?php 
			$confType = array();
			if ($model->type == 0) 
			{
				$confType['type'] = 'image';
				$confType['acceptedFiles'] = 'image/*';
			}
			elseif ($model->type == 1) 
			{
				$confType['type'] = 'video';
				$confType['acceptedFiles'] = 'video/*';
			}

			$csrfToken = \Yii::$app->request->getCsrfToken();
			$type = $confType['type'];
			echo \app\modules\admin\widget\dropzone\DropZone::widget([ 
				'options' => [
					'url' => \Yii::$app->getUrlManager()->createUrl(['admin/media-library/upload','id'=>$model->media_id]) ,
					'dictDefaultMessage' => '<i class="fa fa-cloud-upload"></i> 
					         <span class="main-text"><b>Drop Files</b> to upload</span> <br /> 
					         <span class="sub-text">(or click)</span>  ',
					 // 'maxFilesize' => 3,
					 'acceptedFiles' => $confType['acceptedFiles']
				],
				'clientEvents' => [
					// 'complete' => "function(file){
					// 					console.log(file)
					// 				}",
					'sending' => "function(file, xhr, formData) { 
									formData.append('_csrf', '{$csrfToken}'); 
									formData.append('type', '{$type}'); 
								}",
					'success' => "function(file, response, action) {
									console.log(response);
								}",
				]
			]); 

			?>
		</div>
	</div>


	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">
				<span class="panel-title"><?= Yii::t('app','External Link') ?></span>
			</div>
			<div class="panel-body">


				<?php if ($model->type == 0): ?>
	
				<!-- <form class="form-horizontal" role="form"> -->
				<?= Html::beginForm( ['save-image-url','id'=>$model->media_id] ,'post', ['class'=>'form-horizontal']) ?>
					<div class="form-group mbn">
						<label for="inputHelp" class="col-lg-2 control-label"><?= Yii::t('app','Insert Link Image') ?></label>
						<div class="col-lg-10">
							<div class="">
								
								<?= Html::textInput('externalImageLink',null,['id'=>'inputHelp', 'placeholder'=>'http://','class'=>'form-control','required'=>'required']) ?>

								<span class="help-block mt5">
									<i class="fa fa-bell"></i> Format Url require: http://
								</span>
							
								<button type="submit" class="btn btn-info btn-sm" ><?= Yii::t('app','Submit') ?></button>
							</div>
						</div>
					</div>
				<?= Html::endForm() ?>
				<!-- </form> -->

				<?php elseif ($model->type == 1): ?>


				<?= Html::beginForm( ['save-video-url','id'=>$model->media_id] ,'post', ['class'=>'form-horizontal','id'=>'save-video-url']) ?>
					<div class="form-group mbn">
						<label for="inputHelp" class="col-lg-2 control-label"><?= Yii::t('app','Insert Link Video') ?></label>
						<div class="col-lg-10">
							<div class="">
								
								<?= Html::textInput('externalVideoLink',null,['id'=>'inputHelp', 'placeholder'=>'http://','class'=>'form-control','required'=>'required']) ?>

								<span class="help-block mt5">
									<i class="fa fa-bell"></i> Add Link Only From Youtube
								</span>
							
								<button type="button" id="btnClick" class="btn btn-info btn-sm" ><?= Yii::t('app','Submit') ?></button>
							</div>
						</div>
					</div>
				<?= Html::endForm() ?>


<?php 

$urlPost = \Yii::$app->getUrlManager()->createUrl("admin/media-library/uploadVideo");
$CheckYoutubeLinkWithoutApi = \Yii::$app->getUrlManager()->createUrl("admin/media-library/check-youtube-link-without-api");
$script = <<< JS

 
  // $(document).ready(function(){
    					
  //       $("#btnClick").click(function(){
  //           $('#loadgif').show();
  //           if ($('input[name="externalVideoLink"]').val().toLowerCase().search("youtube") > 0){
  //               var text = $('input[name="externalVideoLink"]').val();
  //               var textfind = text.split("v=");
  //               textfind = textfind[1].split("&");
						
  //               $('<input />').attr('type', 'hidden').attr('name', "idVideo").attr('value', textfind[0]).appendTo('#save-video-url');
  //               $("#save-video-url").submit();

  //           } else {
  //               alert("Link Must From Youtube");
  //               $('#loadgif').hide();
  //           }	
  //       });	
  //   });



  $(document).ready(function(){ 
               
        $("#btnClick").click(function(){ 
            $('#loadgif').show(); 
            if ($('input[name="externalVideoLink"]').val().toLowerCase().search("youtube") > 0){ 
                var text = $('input[name="externalVideoLink"]').val(); 
                var textfind = text.split("v="); 
                textfind = textfind[1].split("&"); 
             
                $.ajax({ 
               
                    type: "GET", 
                    url: '$CheckYoutubeLinkWithoutApi?idVideo=' + textfind[0], 
                    dataType: 'json', 
                    // crossDomain : true, 
                    success:function(data){ 
                      console.log(data); 
                      // alert('Link Valid Bisa disimpan'); 
                      $('<input />').attr('type', 'hidden').attr('name', "idVideo").attr('value', textfind[0]) 
                          .appendTo('#save-video-url'); 
                      $("#save-video-url").submit(); 
                    }, 
                    error: function(data) { 
                        alert("LINK NOT VALID"); 
                        $('#loadgif').hide(); 
                    } 
                 
                }); 
            } else { 
                alert("Link Must From Youtube"); 
                $('#loadgif').hide(); 
            } 
           
        }); 
         
    }); 
    		

JS;


$this->registerJS($script);

 ?>


				<?php endif ?>
			
			</div>
		</div>
	</div>

</div>
	