<?php

use yii\helpers\Html;
use yii\helpers\Json;
use app\modules\admin\MenuAsset;

$this->title = Yii::t('rbac-admin', 'List Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Menu'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

MenuAsset::register($this);

$jsonListGroup = Json::htmlEncode($listGroup);

$this->registerJs("var list_group = {$jsonListGroup};");
$this->registerJs($this->render('_menu.js'));
?>

<style>
    .a1{
        vertical-align: -moz-middle-with-baseline;
        text-decoration: underline;
    }
    .dd-item.panel .dd-handle{
        border:1px solid #ccc !important;
        padding:5px 10px !important;
    }
    .dd-item.panel{
        margin-bottom:5px !important;
    }
    .dd-item > ol >li:first-child{
        margin-top:10px;
    }
    .dd-item{
        margin-bottom:10px;
    }
    .dd-item > .btn{
        margin-top:5px;
        margin-right:5px;
    }
    .dd-handle .panel{
        margin-bottom:0px;
    }
    .dd-handle{
        padding:0px;
        height:auto !important;

    }
    .handle-head{
        cursor:move;
    }
    .li-group:before{
        margin-right:5px;
        cursor: pointer;
    }
    .li-group-default:before{
        margin-right:5px;
    }
</style>

<section class="panel">
    <div class="panel-body">
        <!--COL-4-->
        <div class="col-lg-4">
            <?php echo $this->render('_side_menu', ['routes' => $routes]) ?>
        </div>
        <!--COL-8-->
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo Yii::t('rbac-admin', 'Group name :') ?>
                    <strong><?php echo $menuType?></strong>
                </div>
              <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <strong><?php echo Yii::t('rbac-admin', 'Menu Structure') ?></strong>
                            <p><?php echo Yii::t('rbac-admin', 'Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.');?></p>
                        </div>
                        <div class="col-md-4">
                            <?php echo Html::submitButton(Yii::t('rbac-admin', 'Save Menu <span class=\'fa fa-save\'></span>'), ['name'=> 'save', 'class' => 'btn btn-primary pull-right btn-save-menu']);?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="callout callout-info lead">
                            <h4>Tips !</h4>
                            <small>The Icon should be filled by Font Awesome<br/>Ex. (fa fa-)dashboard <i class="fa fa-dashboard"></i><br/> Click link for referance <a href="http://fontawesome.io/">http://fontawesome.io/</a></small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <form method="POST" id="formMenu">
                        <div class="dd">
                            <ol class="dd-list">
                            <?php
                            if (!empty($menus)) {
                                $i = 0;
                                foreach ($menus as $key => $menu) {
                                    if ($menu->menu_parent == 0) {
                                        echo $this->render('_view', [
                                            'menu' => $menu,
                                            'listGroup' => $listGroup,
                                            'childMenus' => $menus,
                                            'menuType' => $menuType,
                                            'i' => $i
                                        ]);
                                    }
                                    $i++;
                                }
                            }
                            ?>
                            </ol>
                        </div>
                        </form>
                    </div>
              </div>
            </div>
        </div>
        <!--END COL-8-->
    </div>
</section>
