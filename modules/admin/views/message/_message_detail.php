<?php 
use yii\helpers\Html;
?>
<div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Read Mail</h3>

              <div class="box-tools pull-right">
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3><?= $model->subject ?></h3>
                <h5>From: <?= $model->messageOut->receiver?>
                  <span class="mailbox-read-time pull-right"><?=date('d M Y H:i:s', strtotime($model->messageOut->date)); ?></span></h5>
              </div>
              <!-- /.mailbox-read-info -->
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <?= $model->message ?>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
             
            </div>
            <!-- /.box-footer -->
            <div class="box-footer">
              <div class="pull-right">
              <?php
              echo Html::a(' <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button' . Yii::t('rbac-admin', 'Reply'), ['/admin/message/reply?id='.$model->message_id]);
              ?>
              <?php
              echo Html::a(' <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button' . Yii::t('rbac-admin', 'Forward'), ['/admin/message/forward?id='.$model->message_id]);
              ?>
              </div>
              <?php
              echo Html::a(' <button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button' . Yii::t('rbac-admin', 'Delete'), ['/admin/message/delete-message?id='.$model->message_id]);
              ?>
              <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>