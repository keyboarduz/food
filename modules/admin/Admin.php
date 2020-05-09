<?php


namespace app\modules\admin;


use yii\base\Module;
use yii\filters\AccessControl;

class Admin extends Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public $layout = 'cabinet';
    public $defaultRoute = 'ingredient/index';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'except' => ['cabinet/login'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

}