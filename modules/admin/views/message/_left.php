<?php
use yii\helpers\Html;

if ($act == 'create') {
    echo Html::a(Yii::t('rbac-admin', 'Back to Inbox'), ['/admin/message/'],
        ['class' => 'btn btn-primary btn-block margin-bottom']);
} else {
    echo Html::a(Yii::t('rbac-admin', 'Compose'), ['/admin/message/create'],
        ['class' => 'btn btn-primary btn-block margin-bottom']);
}
?>

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Folders</h3>
        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <?php
                $new_span = ($countMessage['count_new_inbox'] != 0) ?  '<span class="label label-primary pull-right">'.$countMessage['count_new_inbox'].'</span>' :  '';
                echo $act == 'index' ? '<li class="active">' : '<li>';
                echo Html::a('<i class="fa fa-inbox"></i>' . Yii::t('rbac-admin', 'Inbox')."(".$countMessage['count_inbox'].")"
                    .$new_span, ['/admin/message']);
            ?>
            </li>
            <?php
                echo $act == 'sent' ? '<li class="active">' : '<li>';
                echo Html::a('<i class="fa fa-envelope-o"></i>' . Yii::t('rbac-admin', 'Sent')."(".$countMessage['count_sent'].")",
                    ['/admin/message/sent']);
            ?>
            </li>
            <?php
                echo $act == 'draft' ? '<li class="active">' : '<li>';
                echo Html::a('<i class="fa fa-file-text-o"></i>' . Yii::t('rbac-admin', 'Draft')."(".$countMessage['count_draft'].")",
                    ['/admin/message/draft']);
            ?>
            </li>
            <?php
                echo $act == 'trash' ? '<li class="active">' : '<li>';
                echo Html::a('<i class="fa fa-trash-o"></i>' . Yii::t('rbac-admin', 'Trash')."(".$countMessage['count_trash'].")",
                    ['/admin/message/trash']);
            ?>
            </li>
        </ul>
    </div>
</div>
