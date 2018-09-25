<?php 
use yii\helpers\Html;
?>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo Yii::t('rbac-admin', $act != 'index' ? ucfirst($act) : 'Inbox') ?></h3>
    <div class="box-tools pull-right">
      <div class="has-feedback">
        <input type="text" class="form-control input-sm" placeholder="Search Mail">
        <span class="glyphicon glyphicon-search form-control-feedback"></span>
      </div>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body no-padding">
    <div class="mailbox-controls">
      <!-- Check all button -->
      <div class="btn-group">
      </div><!-- /.btn-group -->
      <?php
              echo Html::a(' <button type="button" class="btn btn-default btn-sm refresh"><i class="fa fa-refresh"></i></button' . Yii::t('rbac-admin', 'Refresh'), ['/admin/message/' . $act]);
      ?>
    </div>
    <div class="table-responsive mailbox-messages">
      <table class="table table-hover table-stripped">
        <tbody>
          <?php
          if ($act == 'index') {
            echo $this->render('_inbox', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
          }
          if ($act == 'sent') {
            echo $this->render('_sent', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
          }
          if ($act == 'draft') {
            echo $this->render('_draft', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
          }
          if ($act == 'trash') {
            echo $this->render('_trash', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
          }
          ?>
        </tbody>
      </table><!-- /.table -->
    </div><!-- /.mail-box-messages -->
  </div><!-- /.box-body -->
</div>