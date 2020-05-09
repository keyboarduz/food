<?php


namespace app\modules\admin\assets;


use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class AdminAsset extends AssetBundle
{
    public $baseUrl = '@web';
    public $basePath = '@webroot';

    public $css = [
        'css/cabinet.css',
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapPluginAsset::class
    ];
}