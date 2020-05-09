<?php
/* @var $this yii\web\View */
/* @var $model app\models\LoginForm */

use app\modules\admin\assets\CabinetLoginAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

CabinetLoginAsset::register($this);

$this->title = 'Cabinet | Login';

?>
<div class="row login-container">
    <div class="col-xs-12 col-sm-4 col-sm-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">Кабинет</div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(['id' => 'cabinet-login-form', 'enableClientValidation' => false]) ?>

                <?= $form
                    ->field($model, 'username')
                    ->label(false)
                    ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

                <?= $form
                    ->field($model, 'password')
                    ->label(false)
                    ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>


                <div class="row">
                    <div class="col-xs-8">
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    </div>

                    <div class="col-xs-4">
                        <?= Html::submitButton('Вход', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                    </div>
                </div>
                <?php ActiveForm::end() ?>


            </div>
        </div>
    </div>
</div>


