<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ResumeModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="resume-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_alat')->textInput() ?>

    <?= $form->field($model, 'no_po')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_po')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_po')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <?= $form->field($model, 'jumlah_progress')->textInput() ?>

    <?= $form->field($model, 'jumlah_finish')->textInput() ?>

    <?= $form->field($model, 'jumlah_laik')->textInput() ?>

    <?= $form->field($model, 'jumlah_tidak')->textInput() ?>

    <?= $form->field($model, 'extra')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_po')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
