<?php

namespace app\modules\admin\widget\dropzone\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for DropZone Widget
 */
class DropZoneAsset extends AssetBundle
{

    public $sourcePath = '@vendor/docotel/admindesign-asset/theme_smooth';

    public $js = [
        "vendor/plugins/dropzone/dropzone.min.js"
    ];

    public $css = [
        "vendor/plugins/dropzone/css/dropzone.css"
    ];

    /**
     * @var array
     */
    // public $publishOptions = [
    //     'forceCopy' => true
    // ];

}