<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\searchs\DclNodeType */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Content Type List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dcl-node-type-index col-sm-12">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php Pjax::begin(); ?>    
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <h3><?= Yii::t('app', 'Add New Content Types') ?></h3>
            </div>
            <div class="panel-body">
                <?= $this->render('_form', [
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

                        // 'node_type',
                        // 'name',
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'contentOptions'=>['style'=>'white-space: initial; word-wrap: break-word;'],
                            'value' => function($model){
                                return $model->name. '<p>' .$model->description . '</p>';
                            }
                        ],
                        // 'module',
                        // 'description',
                        // 'created',

                        // [
                        //     'class' => 'yii\grid\ActionColumn',
                        //     'header' => Yii::t('app', 'Operation'),
                        // ],


                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => Yii::t('app', 'Operation'),
                            // 'contentOptions'=>['style'=>'max-width: 75px;'],
                            'template' => '<div> {update} | {manageFields} | {manageCategory} | {delete} </div>',
                            'buttons' => [
                                // 'delete' => function ($url, $model) {
                                //                     // return Html::a('<span class="glyphicon glyphicon-trash"></span> '.Yii::t('app','Delete'), Yii::$app->urlManager->createUrl(['bacaditempat/koleksi-dibaca/delete','id' => $model->ID,'edit'=>'t']), [
                                //                     //                 'title' => Yii::t('app', 'Delete'),
                                //                     //                 'class' => 'btn btn-danger btn-sm',
                                //                     //                 'data' => [
                                //                     //                     'confirm' => Yii::t('yii','Are you sure you want to delete this item?'),
                                //                     //                     'method' => 'post',
                                //                     //               ]);
                                // }
                                'update' => function ($url, $model) {
                                    return Html::a(Yii::t('app','update'), Yii::$app->urlManager->createUrl(['admin/content-type/update','id' => $model->node_type,'edit'=>'t']), [
                                            'title' => Yii::t('app', 'update'),
                                            // 'class' => 'btn btn-danger btn-sm',
                                        ]
                                    );
                                },
                                'manageFields' => function ($url, $model) {
                                    return Html::a(Yii::t('app','manage fields'), Yii::$app->urlManager->createUrl(['admin/content-type/manage-fields','id' => $model->node_type]), [
                                            'title' => Yii::t('app', 'manage fields'),
                                            // 'class' => 'btn btn-danger btn-sm',
                                        ]
                                    );
                                },
                                'manageCategory' => function ($url, $model) {
                                    return Html::a(Yii::t('app','manage category'), Yii::$app->urlManager->createUrl(['admin/content-type/manage-category','id' => $model->node_type]), [
                                            'title' => Yii::t('app', 'manage category'),
                                            // 'class' => 'btn btn-danger btn-sm',
                                        ]
                                    );
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a(Yii::t('app','delete'), Yii::$app->urlManager->createUrl(['admin/content-type/delete','id' => $model->node_type,'delete'=>'t']), [
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
