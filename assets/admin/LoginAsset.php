<?php

namespace app\assets\admin;

use yii\web\AssetBundle;

/**
 * @author sefruitstudio@gmail.com
 */
class LoginAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/lte/bower_components/bootstrap/dist/css/bootstrap.min.css',
        'themes/lte/bower_components/font-awesome/css/font-awesome.min.css',
        'themes/lte/bower_components/Ionicons/css/ionicons.min.css',
        'themes/lte/dist/css/AdminLTE.min.css',
        'themes/lte/plugins/iCheck/square/blue.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic'
    ];
    public $js = [
        'themes/lte/bower_components/jquery/dist/jquery.min.js',
        'themes/lte/bower_components/bootstrap/dist/js/bootstrap.min.js',
        'themes/lte/plugins/iCheck/icheck.min.js',
        'themes/lte/custom-login.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
