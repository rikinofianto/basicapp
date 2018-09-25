<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\searchs\Group */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="panel">
    <div class="panel-body">
        <div class="group-index">

            <!-- <h1><?= Html::encode($this->title) ?></h1> -->
            <p>
                <?= Html::a('Create Group', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?php Pjax::begin(['id' => 'group']) ?>
            <?php echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'No.'
                    ],

                    [
                        'attribute' => 'group_id',
                        'value' => function ($model) {
                            return str_repeat('-', $model->level) . ' ' . $model->group_id;
                        }
                    ],
                    'name',
                    'detail:ntext',
                    'configuration:ntext',
                    'level',
                    // 'order',
                    // 'left',
                    // 'right',
                    // 'parent_id',
                    // 'path',
                    // 'url:ntext',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end() ?>
        </div>
    </div>
</section>
