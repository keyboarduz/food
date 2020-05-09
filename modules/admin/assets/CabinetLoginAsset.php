<?php
namespace app\modules\admin\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class CabinetLoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/cabinet.css',
    ];

    public $depends  = [
        YiiAsset::class,
        BootstrapAsset::class,
    ];
}