<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ResumeModel $model */

$this->title = 'Update Resume Kegiatan: ' . $model->id_resume;
$this->params['breadcrumbs'][] = ['label' => 'Resume Kegiatan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_resume, 'url' => ['view', 'id_resume' => $model->id_resume]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="resume-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
