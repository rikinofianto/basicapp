<?php
use yii\helpers\Html;
use yii\helpers\Json;

$opts = Json::htmlEncode([
    'routes' => $routes
  ]);

$this->registerJs("var _opts = {$opts};");

?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<!--Begin Module accordion-->
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Module <span class="fa fa-chevron-down pull-right" aria-hidden="true"></span>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <div>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
              <a class="pull-right" href="#routes" aria-controls="routes" role="tab" data-toggle="tab">Group Item</a>
            </li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="routes">
            <br/>
                <div class="form-group">
                  <input type="text" class="form-control input-sm search-list-menu" data-target="available" value="" placeholder="<?php echo Yii::t('rbac-admin', 'Search Routes');?>">
                </div>
                <div class="well">
                    <div class="row" style="max-height:220px;overflow:auto;">
                        <div class="form-group" id="list-routes" data-target="available">
                            <?php
                            if (!empty($routes)):
                                foreach ($routes as $route):
                            ?>
                                <label class="col-sm-12">
                                    <input type="checkbox" class="route" data-val="<?php echo $route ?>" name="route[]" value=""> <?php echo $route ?>
                                </label>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo Html::a(Yii::t('rbac-admin', 'Select All'), 'javascript:void(0)', ['class' => 'a1', 'id' => 'route-select', ]);?>
                        <?php echo Html::submitButton(Yii::t('rbac-admin', 'Add to Menu'), ['class' => 'btn btn-default pull-right', 'id' => 'add-group-to-menu']);?>
                    </div>
                </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
<!--End module accordion-->
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Custom Link <span class="fa fa-chevron-down pull-right" aria-hidden="true"></span>
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        <div class="well">
            <div class="row">
                <div class="form-group">
                    <label>URL</label>
                    <input type="text" name="url" id="url" class="form-control" placeholder="http://" value="http://" />
                </div>
                <div class="form-group">
                    <label>Link Text</label>
                    <input type="text" name="label" id="label" class="form-control" placeholder="Sample text" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo Html::submitButton(Yii::t('rbac-admin', 'Add to Menu'), ['class' => 'btn btn-default pull-right', 'id' => 'add-custom-to-menu']) ?>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
