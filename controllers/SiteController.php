<?php

namespace app\controllers;

use app\modules\admin\models\DishAdvancedSearch;
use app\modules\admin\models\Ingredient;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDish() {
        $ingredients = Ingredient::getIngredientsAsArray();
        $searchModel = new DishAdvancedSearch();

        $dishes = $searchModel->search(Yii::$app->getRequest()->queryParams);

        return $this->render('dish', [
            'searchModel' => $searchModel,
            'dishes' => $dishes,
            'ingredients' => $ingredients,
        ]);
    }
}
