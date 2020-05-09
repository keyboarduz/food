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

        $queryParams = Yii::$app->getRequest()->queryParams;

        $dishes = [];
        if ( isset($queryParams['DishAdvancedSearch']['_ingredients'])
            && is_countable($queryParams['DishAdvancedSearch']['_ingredients'])
            && count($queryParams['DishAdvancedSearch']['_ingredients']) < 2 )
        {
            Yii::$app->getSession()->setFlash('warning', 'Выберите больше ингредиентов');
        }
        else
        {
            $dishes = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('dish', [
            'searchModel' => $searchModel,
            'dishes' => $dishes,
            'ingredients' => $ingredients,
        ]);
    }
}
