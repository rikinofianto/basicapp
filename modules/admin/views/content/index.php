<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\searchs\DclFieldDataBody */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Content');
$this->params['breadcrumbs'][] = $this->title;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/docotel/admindesign-asset/theme_smooth');
?>
<div class="dcl-field-data-body-index">

    <div class="row">
        <div class="panel" style="border: none;">
            <div class="panel-heading">
                <h3 class="pull-left"><?= Html::encode($this->title) ?></h3>
                 <?= Html::a(Yii::t('app', 'Add Content'), ['create'], ['class' => 'btn btn-success pull-right mt5']) ?>
            </div>
            <div class="panel-body">


                <?php Pjax::begin(); ?>   

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            // 'id',
                            'title',
                            // 'node_type',
                            [
                                'attribute' => 'node_type',
                                // 'filter' => ['a'=> 'b'],
                                'filter' => yii\helpers\ArrayHelper::map(\app\modules\admin\models\DclNodeType::find()->all(), 'node_type', 'name'),
                                'value' => function($model){
                                    return $model->nodeType->name;
                                }
                            ],
                            // 'node_id',
                            [
                                'attribute' => 'changed',
                                'format' => ['date','php:d M Y H:i:s'],
                                'value' => function($model){
                                    return $model->node->changed;
                                },

                                'filter' => '<div class="input-group date datetimepicker" >
                                                <span class="input-group-addon cursor">
                                                  <i class="fa fa-calendar"></i>
                                                </span>'
                                                .Html::activeInput('text', $searchModel, 'changed', ['class' => 'form-control']).
                                            '</div>',
                                // 'filterInputOptions' => [
                                //     'class' => 'form-control datetimepicker',
                                //     'data-format' => "dd-mm-yyyy"
                                // ],


                                // 'filter' => \yii\jui\DatePicker::widget([
                                //     'language' => 'en',
                                //     'dateFormat' => 'yyyy-MM-dd',
                                //     'model' => $searchModel,
                                //     'attribute' => 'slot_date',
                                //     ]    ),

                            ],

                            [
                                'attribute' => 'publish',
                                'format' => 'boolean',
                                'filter' => [0 => 'No', 1 => 'Yes'],
                                'value' => function($model){
                                    return $model->node->publish;
                                }
                            ],

                            [
                                'attribute' => 'status',
                                'filter' => [0 => Yii::t('app','Drafted'), 1 => Yii::t('app','Published')],
                                'value' => function($model){
                                    return ($model->node->status ? Yii::t('app','Published') : Yii::t('app','Drafted'));
                                }
                            ],



                            // 'bundle',
                            // 'deleted',
                            // 'language',
                            // 'delta',
                            // 'body_value:ntext',
                            // 'body_summary:ntext',
                            // 'body_format',
                            // 'meta_tag',
                            // 'slideshow:ntext',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>

                    <?php 
                    $script = "
                    $('.datetimepicker').datetimepicker({
                        format: 'DD-MM-YYYY',
                        pickTime: false,
                    });";

                    $this->registerJs($script);
                    ?>

                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>




<?php 

$this->registerCssFile($directoryAsset."/vendor/plugins/datepicker/css/bootstrap-datetimepicker.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
    'media' => 'screen',
    'position' => \yii\web\View::POS_END

], 'css-print-theme');



$this->registerJsFile($directoryAsset.'/vendor/plugins/moment/moment.min.js',   [
      'depends' => [yii\web\JqueryAsset::className()],
      'position' => \yii\web\View::POS_HEAD
    ],
    'moment-handler'); 



$this->registerJsFile($directoryAsset.'/vendor/plugins/datepicker/js/bootstrap-datetimepicker.min.js',   [
      'depends' => [yii\web\JqueryAsset::className()],
      'position' => \yii\web\View::POS_HEAD
    ],
    'datepicker-handler'); 


 ?>