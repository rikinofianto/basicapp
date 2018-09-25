<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\searchs\DclMedia */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Media Library');
$this->params['breadcrumbs'][] = $this->title;


  $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/docotel/admindesign-asset/theme_smooth');
?>

<div class="tray tray-center gallery-page">

    
    <div class="mh15 pv15 br-b br-light" >
        <div class="row">



            <!-- Template layout Left Top Bar --> 

            <?php echo $this->render('_search', ['model' => $searchModel]); ?> 

            <!-- !Template layout Left Top Bar --> 


            <!-- !Template layout Right side Top Bar --> 
            <div class="col-xs-5 text-right">
                <?php echo Html::a("<i class=\"fa fa-plus\"></i> ".Yii::t('app', 'Create New Media'), ['create'], ['class' => 'btn btn-success']) ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default to-grid">
                        <span class="fa fa-th"></span>
                    </button>
                    <button type="button" class="btn btn-default to-list">
                        <span class="fa fa-navicon"></span>
                    </button>
                </div>
            </div>
            <!-- !Template layout Right side Top Bar --> 

        </div>
    </div>

    <div id="mix-container">

        <?php if (!$models): ?>
        <div class="fail-message">
            <span>No items were found matching the selected filters</span>
        </div>
        <?php endif ?>

        <?php foreach ($models as $models): ?>
            <div class="mix label1 folder1">
                <div class="panel p6 pbn">
                    <div class="of-h proportion-image">
                        <?php 
                            $RealpathImage = Yii::getAlias('@webroot').'/uploads/'.$models->path_name.'/'.$models->setting;
                            $pathImage = Yii::$app->homeUrl .'uploads/'.$models->path_name.'/'.$models->setting;
                            
                            if (filter_var($models->setting, FILTER_VALIDATE_URL)) 
                            {
                                $pathImage = $models->setting;
                            }
                            else
                            {
                                if (!file_exists($RealpathImage) || !$models->setting || $models->type == 1) {
                                    $pathImage = $models->type == 0 ? $directoryAsset.'/assets/img/stock/placeholder.png' : ($models->type == 1 ? $directoryAsset.'/assets/img/stock/placeholder-vid.jpg' : $directoryAsset.'/assets/img/stock/placeholder.png');
                                }
                            }
                         ?>
                        <?= Html::a("<img src=\"{$pathImage}\" class=\"img-responsive\" title=\"{$models->name}\">",
                            Yii::$app->urlManager->createUrl(['admin/media-library/view','id' => $models->media_id]) ,['class'=>'fa fa-calendar'] ) ?>
        
                        <div class="row table-layout">
                            <div class="col-xs-8 va-m pln">
                                <!-- <h6>lost_typewritter.jpg</h6> -->
                                <h6><?= $models->name ?></h6>
                            </div>
                            <div class="col-xs-4 text-right va-m prn">

                                <div class="btn-group">
                
                                    <?= Html::a("<i class=\"fa fa-trash\"></i>", Yii::$app->urlManager->createUrl(['admin/media-library/delete','id' => $models->media_id]) ,['class'=>'btn btn-xs btn-info light','data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],] ) ?>

                                    <?= Html::a("<i class=\"fa fa-pencil\"></i>", Yii::$app->urlManager->createUrl(['admin/media-library/update','id' => $models->media_id]) ,['class'=>'btn btn-xs btn-info'] ) ?>

                                    <?= Html::a("<i class=\"fa fa-plus-circle\"></i>", Yii::$app->urlManager->createUrl(['admin/media-library/add-content','id' => $models->media_id]) ,['class'=>'btn btn-xs btn-info dark'] ) ?>
                                </div>

                            </div>
                        </div>

                        <?= $models->type == 0 ? '<div id="source-button" class="btn btn-success btn-xs light" style="cursor:help;">Image</div>' : ($models->type == 1 ? '<div id="source-button" class="btn btn-danger btn-xs light" style="cursor:help;">Video</div>' : '<div id="source-button" class="btn btn-warning btn-xs light" style="cursor:help;">Other</div>') ?>
                    </div>

                </div>
            </div>
        <?php endforeach ?>



    </div>
    <div class="col-sm-12">      
        <?php echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            ]); ?>
    </div>

</div>


<?php 


$this->registerJsFile($directoryAsset.'/vendor/plugins/magnific/jquery.magnific-popup.js', ['depends' => [yii\web\JqueryAsset::className()]]); 

$this->registerJsFile($directoryAsset.'/vendor/plugins/mixitup/jquery.mixitup.min.js', ['depends' => [yii\web\JqueryAsset::className()]]); 


$this->registerJsFile($directoryAsset.'/assets/js/gallery.js', 
    [
      'depends' => [yii\web\JqueryAsset::className()],
      'position' => \yii\web\View::POS_END
    ]
    ); 

// $this->registerJsFile($directoryAsset.'/vendor/plugins/magnific/jquery.magnific-popup.js', ['depends' => [yii\web\JqueryAsset::className()]]); 

// $this->registerJsFile($directoryAsset.'/vendor/plugins/mixitup/jquery.mixitup.min.js', ['depends' => [yii\web\JqueryAsset::className()]]); 

// $this->registerJsFile($directoryAsset.'/assets/js/gallery.js', ['depends' => [yii\web\JqueryAsset::className()]]); 


 ?>

