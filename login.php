<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$style = <<< CSS

CSS;
$this->registerCss($style);
//$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <div class="row">
    <div class="col-md-7">
        <?php
        echo Html::img(Yii::getAlias('@web').'/img/game_1.jpg');
        ?>
    </div>
        <div class="col-md-5">
            <h1>Login</h1>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-8 form-control'],
                'errorOptions' => ['class' => 'offset-lg-3 col-lg-12 invalid-feedback'],
            ],
        ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"offset-lg-3 col-lg-12 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>

        <div class="form-group">
            <div class="offset-lg-3 col-lg-9">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
        </div>



    <?php ActiveForm::end(); ?>

    </div>
    </div>
