<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\searchs\DclNodeType */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = Yii::t('app', 'Fields');
$this->title = Yii::t('app', 'Manage {modelClass}: ', [
    'modelClass' => 'Fields',
]) . ucfirst($id);


$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dcl-node-type-index col-sm-12">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php Pjax::begin(); ?>    
    <div class="col-xs-12">
        <div class="panel">
            <div class="panel-heading">
                <?= $this->title ?>
                <?= Html::a(Yii::t('app','Back'), ['index'] , ['title' => Yii::t('app', 'Kembali'),'class' => 'btn btn-primary pull-right mt5',]); ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <h3><?= Yii::t('app', 'Add New Fields') ?></h3>
            </div>
            <div class="panel-body">
                <?= $this->render('_form-fields', [
                    'model' => $modelForm,
                    ]) ?>

            </div>

        </div>
    </div>

    <div class="col-md-8">
        <div class="panel">
            <div class="panel-heading">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // [
                        //     'attribute' => 'name',
                        //     'format' => 'raw',
                        //     'contentOptions'=>['style'=>'white-space: initial;'],
                        //     'value' => function($model){
                        //         return $model->name. '<p>' .$model->description . '</p>';
                        //     }
                        // ],



                        // 'id',
                        // 'node_type',
                        
                        'field_name',
                        'type',
                        'active:boolean',
                        'required:boolean',
                        // 'message',
                        [
                            'attribute'=>'message',
                            'value' => function($model){
                                return $model->required ? $model->message : '';
                            }
                        ],



                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => Yii::t('app', 'Operation'),
                            // 'contentOptions'=>['style'=>'max-width: 75px;'],
                            'template' => '<div> {update} | {delete} </div>',
                            'buttons' => [

                                'update' => function ($url, $model) {
                                    return Html::a(Yii::t('app','update'), Yii::$app->urlManager->createUrl(['admin/content-type/fields-update','id' => $model->id,'edit'=>'t']), [
                                            'title' => Yii::t('app', 'update'),
                                            // 'class' => 'btn btn-danger btn-sm',
                                        ]
                                    );
                                },

                                'delete' => function ($url, $model) {
                                    return Html::a(Yii::t('app','delete'), Yii::$app->urlManager->createUrl(['admin/content-type/fields-delete','id' => $model->id,'delete'=>'t']), [
                                            'title' => Yii::t('app', 'delete'),
                                            // 'class' => 'btn btn-danger btn-sm',
                                            'data' => [
                                                'confirm' => Yii::t('yii','Are you sure you want to delete this item?'),
                                                'method' => 'post',
                                            ],
                                        ]
                                    );
                                },
                            ],
                        ],


                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>


</div>
