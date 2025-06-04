<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
?>

<h3 class="text-center mb-4"><?= Html::encode($this->title) ?></h3>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['autocomplete' => 'off'],
]); ?>

<?= $form->field($model, 'username')->textInput([
    'autofocus' => true,
    'placeholder' => 'Username',
    'class' => 'form-control',
]) ?>

<?= $form->field($model, 'password')->passwordInput([
    'placeholder' => 'Password',
    'class' => 'form-control',
]) ?>

<?= $form->field($model, 'rememberMe')->checkbox([
    'template' => "<div class=\"form-check\">{input} {label}</div>\n{error}",
]) ?>

<div class="d-grid mt-3">
    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
</div>

<?php ActiveForm::end(); ?>
