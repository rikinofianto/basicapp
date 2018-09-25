<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Message */

$this->title = Yii::t('rbac-admin', 'Create Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs($this->render('_create.js'));

$act = Yii::$app->controller->action->id;
?>
<section class="panel">
    <div class="panel-body">
        <div class="message-create">
            <div class="row">
                <div class="col-md-3">
                    <?php
                        echo $this->render('_left', [
                            'act' => $act,
                            'count_message' => $count_message,
                        ]);
                    ?>
                </div>
                <div class="col-md-9">
                    <?php
                        echo $this->render('_form', [
                            'model' => $model,
                        ]);
                    ?>
                </div>
              </div>
        </div>
    </div>
</section>
