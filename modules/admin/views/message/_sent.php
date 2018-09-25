<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

Pjax::begin();
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'summaryOptions' => ['class' => 'pull-right'],
    'showHeader' => false,
    'columns' => [
        [
            'contentOptions' => ['style' => 'width:30px;'],
            'format' => 'raw',
            'value' => function ($model) {
                return '<input type="checkbox" name="message[]" value="' . $model->message_id . '">';
            }
        ],
        [
            'attribute' => 'subject',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->subject, ['/admin/message/view', 'id' => $model->message_id]);
            }
        ],
        [
            'contentOptions' => ['style' => 'width:180px;'],
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date('d M Y H:i:s', strtotime($model->created_at));
            }
        ]
    ]
]);
Pjax::end();
