<?php

/* @var $this yii\web\View */
/* @var $dishes array */
/* @var $searchModel yii\db\ActiveRecord */
/* @var $ingredients array */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Поиск блюдо';
?>
<div class="site-dish">

    <div class="body-content">

        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <?php $form = ActiveForm::begin([
                    'action' => ['dish'],
                    'method' => 'get',
                ]); ?>

                <?= $form->field($searchModel, '_ingredients')->checkboxList($ingredients, ['separator'=>'<br/>']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-sx-12 col-sm-9">
                <?php if ($dishes): ?>
                    <?php foreach ($dishes as $dish): ?>
                        <div class="col-xs-12">
                            <h2><?= Html::encode($dish['name']) ?></h2>

                            <p>
                                <?php foreach ($dish['ingredients'] as $ingredient): ?>
                                    <span class="label label-primary"><?=Html::encode($ingredient['name'])?></span>
                                <?php endforeach; ?>
                            </p>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="well">
                        Ничего не найдено
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
