<?php

namespace app\modules\admin;

use yii\web\AssetBundle;

/**
 * AutocompleteAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class MenuAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/modules/admin';
    /**
     * @inheritdoc
     */
    public $css = [
        'nestable.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'jquery.nestable.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
