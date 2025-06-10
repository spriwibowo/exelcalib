<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\JobModel $model */

$this->title = 'Update Kegiatan Kalibrasi: ' . $model->id_job;
$this->params['breadcrumbs'][] = ['label' => 'Kegiatan Kalibrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_job, 'url' => ['view', 'id_job' => $model->id_job]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="job-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
