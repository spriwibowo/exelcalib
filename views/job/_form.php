<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\JobModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="job-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_alat')->textInput() ?>

    <?= $form->field($model, 'id_template')->textInput() ?>

    <?= $form->field($model, 'no_po')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_po')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_po')->textInput() ?>

    <?= $form->field($model, 'id_user')->textInput() ?>

    <?= $form->field($model, 'id_jadwal')->textInput() ?>

    <?= $form->field($model, 'tgl_kalibrasi')->textInput() ?>

    <?= $form->field($model, 'extra')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_po')->textInput() ?>

    <?= $form->field($model, 'file')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'laik')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ketidakpastian')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stt_laik')->textInput() ?>

    <?= $form->field($model, 'serial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'merk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_resume')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
