<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TemplateModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="template-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_alat')->textInput() ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'extra')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'laik_sheet')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'laik_row')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ketidakpastian_sheet')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ketidakpastian_row')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
