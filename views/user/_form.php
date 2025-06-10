<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use app\models\User;
?>

<div class="user-form container mt-4">

    <?php $form = ActiveForm::begin([
        'id' => 'user-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'layout' => 'horizontal', // penting di bootstrap5
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-3',
                'wrapper' => 'col-sm-6',
                'error' => 'col-sm-3',
                'hint' => '',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipe')->dropDownList(User::ListTipe(), ['prompt' => 'Pilih Tipe']) ?>

    <div class="form-group row mt-3">
        <div class="offset-sm-3 col-sm-6">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
