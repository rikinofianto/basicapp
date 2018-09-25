<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\admin\components\ActionHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Menu */

$this->title = Yii::t('rbac-admin', 'Create Menu');
// $this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="panel">
    <div class="panel-body">
        <div class="menu-create">
            <div class="col-sm-4">
                <?php
                    echo $this->render('_form', [
                        'model' => $model,
                    ])
                ?>
            </div>
            <div class="col-sm-1">
            </div>
            <div class="col-sm-7">
                <?php // Pjax::begin(); ?>
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => Yii::t('rbac-admin', 'No.'),
                        ],
                        [
                            'attribute' => 'title',
                            'label' => Yii::t('rbac-admin', 'Title'),
                        ],
                        [
                            'attribute' => 'description',
                            'label' => Yii::t('rbac-admin', 'Description'),
                        ],
                        [
                            'label' => 'Aksi',
                            'format' => 'raw',
                            'value' => function ($model) { 
                                return Html::a(Yii::t('rbac-admin', 'List Link'), ['/admin/menu/list-menu', 'id' => $model->menu_type])
                                . ' | ' . Html::a(Yii::t('rbac-admin', 'Update'), ['/admin/menu/', 'id' => $model->menu_type])
                                . ' | ' . Html::a(Yii::t('rbac-admin', 'Delete'), ['/admin/menu/delete', 'id' => $model->menu_type],
                                    ['data' => ['confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')]]);
                            }
                        ]
                    ]
                ]);
                ?>
                <?php // Pjax::end(); ?>
            </div>
        </div>
    </div>
</section>
