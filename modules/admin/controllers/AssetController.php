<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\modules\admin\components\ConsoleCommandRunner;

class AssetController extends Controller
{
    public function actionClearAsset()
    {
        $directory = Yii::$app->basePath . "/web/assets";
        $this->recursiveRmdir($directory, true);
    }

    public function actionClearUpload()
    {
        $directory = Yii::$app->basePath . "/uploads";
        if (!is_dir($directory))
            mkdir($directory, 0755);
        $this->recursiveRmdir($directory, true);
    }

    public function actionClearRuntime()
    {
        $directory = Yii::$app->basePath . "/runtime";
        if (!is_dir($directory))
            mkdir($directory, 0755);
        $this->recursiveRmdir($directory, true);
    }

    private function recursiveRmdir($directory, $empty = false)
    {
        $directory = preg_replace('@[\\/]$@', '', $directory);

        if(!file_exists($directory) || !is_dir($directory))
            return false;
        elseif(!is_readable($directory))
            return false;
        else {

            $handle = opendir($directory);
            while (false !== ($item = readdir($handle))) {
                if ($item != '.' && $item != '..') {
                    $path = $directory . DIRECTORY_SEPARATOR . $item;
                    chmod($path, 0755);
                    if (strpos($path, '.gitignore') === false) {
                        if (is_dir($path))
                            $this->recursiveRmdir($path);
                        elseif(unlink($path))
                            echo $path . "\n";
                    }
                }
            }
            closedir($handle);

            if ($empty == false) {
                if (rmdir($directory))
                    echo $directory . "\n";
                else
                    return false;
            }
            return true;
        }
    }
}
