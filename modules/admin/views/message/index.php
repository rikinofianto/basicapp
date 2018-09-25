<?php

use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\searchs\Message */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Messages');
$this->params['breadcrumbs'][] = $this->title;

$act  = Yii::$app->controller->action->id;
$_act = Json::htmlEncode($act);
$this->registerJs("var action = {$_act};");
$this->registerJs($this->render('_message.js'));
?>
<section class="panel">
    <div class="panel-body">
        <div class="message-index">
          <div class="row">
            <div class="col-md-3">
                <?php
                    echo $this->render('_left', [
                            'act' => $act,
                            'countMessage' => $countMessage,
                        ]);
                ?>
            </div>
            <div class="col-md-9">
                <?php
                    echo $this->render('_right', [
                        'act' => $act,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);
                ?>
            </div>
          </div>
        </div>
    </div>
</section>