<?php

use app\modules\admin\models\Ingredient;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\IngredientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ingredients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ingredient', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {changeStatus}',
                'buttons' => [
                    'changeStatus' => function ($url, $model, $key) {
                        return $model->status == Ingredient::STATUS_SHOW
                            ? Html::a('скрыт',
                                ['change-status', 'id' => $model->id, 'status' => 0],
                                [
                                    'class' => 'btn btn-xs btn-warning',
                                    'data' => [
                                        'method' => 'post',
                                    ]
                                ])
                            : Html::a('показать',
                                ['change-status', 'id' => $model->id, 'status' => 1],
                                [
                                    'class' => 'btn btn-xs btn-success',
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]);
                    },
                ]
            ],
        ],
    ]); ?>


</div>
