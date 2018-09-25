<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\searchs\DclMedia */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List {modelClass}: ', ['modelClass' => 'Media',]) . $media->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Media'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->media_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Media Content');


  $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/docotel/admindesign-asset/theme_smooth');
?>



<div class="tray tray-center gallery-page">

    <div class="mh15 pv15 br-b br-light" >
        <div class="row">


          <!-- Template layout Left Top Bar -->
          <div class="col-xs-7">
            <div class="mix-controls ib">
              <h1><?= Html::encode($this->title) ?></h1>
            </div>
          </div>
          <!-- !Template layout Left Top Bar -->


            <div class="col-xs-5 text-right">
                <?php echo Html::a("<i class=\"fa fa-plus\"></i> ".Yii::t('app', 'Add Media'), Yii::$app->urlManager->createUrl(['admin/media-library/add-content','id' => $media->media_id]), ['class' => 'btn btn-info']) ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default to-grid">
                        <span class="fa fa-th"></span>
                    </button>
                    <button type="button" class="btn btn-default to-list">
                        <span class="fa fa-navicon"></span>
                    </button>
                </div>
            </div>


        </div>
    </div>


    <?php if ($media->type == 0): ?>
    <!-- Image Content -->
    <div id="mix-container">

        <?php if (!$models): ?>
          <div class="fail-message" style="display: block;">
            <span>No items were found matching the selected media</span>
          </div>
        <?php endif ?>

        <?php foreach ($models as $models): ?>
            <div class="mix label1 folder1">
                <div class="panel p6 pbn">
                    <div class="of-h">
                        <?php 
                          $RealpathImage = Yii::getAlias('@webroot').'/uploads/'.$models->parent->path_name.'/'.$models->path;
                          $pathImage = Yii::$app->homeUrl .'uploads/'.$models->parent->path_name.'/'.$models->path;

                          if (filter_var($models->path, FILTER_VALIDATE_URL)) 
                          {
                              $pathImage = $models->path;
                          }
                          else
                          {
                            if (!file_exists($RealpathImage) || !$models->parent->setting ) 
                            {
                                $pathImage = $directoryAsset.'/assets/img/stock/placeholder.png';
                            }
                          }
                         ?>
                         <div class="proportion-image">
                            <img src="<?= $pathImage ?>" class="img-responsive" title="<?= $models->path ?>">
                        </div>
        
                        <div class="row table-layout">
                            <div class="col-xs-8 va-m pln">
                                <!-- <h6>lost_typewritter.jpg</h6> -->
                                <h6><?= basename($models->path) ?></h6>
                            </div>
                            <div class="col-xs-4 text-right va-m prn">

                                <div class="btn-group">
                
                                    <?= Html::a("<i class=\"fa fa-trash\"></i>", Yii::$app->urlManager->createUrl(['admin/media-library/delete-content','id' => $models->media_content_id]) ,['class'=>'btn btn-xs btn-info light','data' => [
                                          'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                          'method' => 'post',
                                      ],] ) ?>

                                    <!-- <?= Html::a("<i class=\"fa fa-pencil\"></i>", Yii::$app->urlManager->createUrl(['admin/media-library/update-image','id' => $models->media_content_id]) ,['class'=>'btn btn-xs btn-info'] ) ?> -->

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php endforeach ?>

        <div class="gap"></div>
        <div class="gap"></div>
        <div class="gap"></div>
        <div class="gap"></div>

    </div>
    <!-- !Image Content -->
    <?php elseif ($media->type == 1): ?>
    <!-- Video Content -->
    <div class="col-sm-12">
      <div id="timeline" class="mt30 timeline-single">

        <!-- Timeline Divider -->
        <div class="row">

          <!-- Timeline - Left Column -->
          <div class="col-sm-6 left-column">

            

            <?php foreach ($models as $models): ?>
              <?php $detailVideo = json_decode($models->setting);
               ?>
            <div class="timeline-item">
              <div class="timeline-icon">
                <span class="fa fa-video-camera text-primary"></span>
              </div>
              <div class="panel">
                <div class="panel-heading">
                  <span class="panel-title">
                    <span class="glyphicon glyphicon-facetime-video"></span> <?= $detailVideo->snippet->title ? $detailVideo->snippet->title : $models->path ?> 
                  </span>
                  <div class="panel-header-menu pull-right mr10 text-muted fs12"> <?= date('d-m-Y H:i', $models->created); ?> </div>
                </div>
                <div class="panel-body">

                  <div class="embed-responsive embed-responsive-16by9" style="height: 481px;">
                    <?php

                      $RealpathImage = Yii::getAlias('@webroot').'/uploads/'.$models->parent->path_name.'/'.$models->path;
                      $pathVideo = Yii::$app->homeUrl .'uploads/'.$models->parent->path_name.'/'.$models->path;
                      if (!file_exists($RealpathImage) || !$models->parent->setting ) 
                      {
                        $pathImage = $directoryAsset.'/assets/img/stock/placeholder.png';
                      }

                      ?>
                    <?php if (!$detailVideo->kind): ?>
                      <a href="<?= $pathVideo ?>" title="" target="_blank" class="video-link">
                        <img src="<?= $directoryAsset.'/assets/img/stock/video-placeholder.png' ?>" title="<?= $models->path ?>" style="width: 100%;">
                      </a>
                    <?php else : ?>
                      <a href="https://www.youtube.com/watch?v=<?= $models->path ?>" title="" target="_blank" class="video-link">
                        <img src="https://i.ytimg.com/vi/<?= $models->path ?>/hqdefault.jpg" title="<?= $detailVideo->snippet->title ?>" style="width: 100%;">
                      </a>
                    <?php endif ?>

                  </div>

                  <!-- Panel Video Button -->
                  <div class="col-xs-12 text-right va-m prn pt10" >
                    <div class="btn-group">
                    <?= Html::a("<i class=\"fa fa-trash\"></i>", Yii::$app->urlManager->createUrl(['admin/media-library/delete-content','id' => $models->media_content_id]) ,['class'=>'btn btn-sm btn-info light','onClick'=>'return confirm("Are you sure?")'] ) ?>

                      <!-- <?= Html::a("<i class=\"fa fa-pencil\"></i>", Yii::$app->urlManager->createUrl(['admin/media-library/update-video','id' => $models->media_content_id]) ,['class'=>'btn btn-sm btn-info'] ) ?> -->
                    </div>
                  </div>
                  <!-- Panel Video Button -->

                </div>
              </div>
            </div>
          <?php endforeach ?>


          </div>
          <!-- Timeline - Left Column -->

        </div>
        <!-- Timeline Divider -->

      </div>
    </div>
    <!-- !Video Content -->
    <?php endif ?>



    <div class="col-sm-12">      
        <?php echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            ]); ?>
    </div>

</div>




<?php 

$script = <<< JS

    // Add Gallery Item to Lightbox
    $('.mix img').magnificPopup({
      type: 'image',
      callbacks: {
        beforeOpen: function(e) {
          // we add a class to body to indicate overlay is active
          // We can use this to alter any elements such as form popups
          // that need a higher z-index to properly display in overlays
          $('body').addClass('mfp-bg-open');

          // Set Magnific Animation
          this.st.mainClass = 'mfp-zoomIn';

          // Inform content container there is an animation
          this.contentContainer.addClass('mfp-with-anim');
        },
        afterClose: function(e) {

          setTimeout(function() {
            $('body').removeClass('mfp-bg-open');
            $(window).trigger('resize');
          }, 1000)

        },
        elementParse: function(item) {
          // Function will fire for each target element
          // "item.el" is a target DOM element (if present)
          // "item.src" is a source that you may modify
          item.src = item.el.attr('src');
        },
      },
      overflowY: 'scroll',
      removalDelay: 200, //delay removal by X to allow out-animation
      prependTo: $('#content_wrapper')
    });
    


    $('.video-link').on('click',function() {
      var href = $(this).attr('href');
      if ($(this).attr('href').toLowerCase().search("youtube") > 0)
      { 
        var textfind = href.split("v="); 
        textfind = textfind[1].split("&");
        var link = 'https://www.youtube.com/embed/' + textfind[0];

        bootbox.alert({
          size: "large",
          message: '<div class="embed-responsive embed-responsive-16by9" style="height: 481px;">' +
                    '<iframe class="embed-responsive-item" src="' + link + '" frameborder="0" allowfullscreen=""></iframe>' +
                    '</div>'
        });
      }
      else
      {
        bootbox.alert({
          size: "large",
          message: '<div class="embed-responsive embed-responsive-16by9" style="height: 481px;">' +
                    '<video width="100%" height="auto" controls>'+
                        '<source src="' + href + '" type="video/mp4">'+
                          'Your browser does not support the video tag.'+
                      '</video>' +
                    '</div>'
        });
      }


      return false;


    });


JS;

$this->registerJs($script);

// $this->registerJsFile($directoryAsset.'/vendor/plugins/magnific/jquery.magnific-popup.js', ['depends' => [yii\web\JqueryAsset::className()]]); 

// $this->registerJsFile($directoryAsset.'/vendor/plugins/mixitup/jquery.mixitup.min.js', ['depends' => [yii\web\JqueryAsset::className()]]); 


        // 'vendor/plugins/magnific/magnific-popup.css'


$this->registerJsFile($directoryAsset.'/vendor/plugins/magnific/jquery.magnific-popup.js', ['depends' => [yii\web\JqueryAsset::className()]]); 

$this->registerJsFile($directoryAsset.'/vendor/plugins/mixitup/jquery.mixitup.min.js', ['depends' => [yii\web\JqueryAsset::className()]]); 


$this->registerJsFile($directoryAsset.'/assets/js/gallery.js', 
    [
      'depends' => [yii\web\JqueryAsset::className()],
      'position' => \yii\web\View::POS_END
    ]
    ); 

// $this->registerCssFile($directoryAsset.'/vendor/plugins/magnific/magnific-popup.css', [
//     'depends' => [yii\bootstrap\BootstrapAsset::className()],
//     'media' => 'print',
// ], 'css-print-theme');

 ?>
