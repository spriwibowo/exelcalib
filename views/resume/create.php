<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ResumeModel $model */

$this->title = 'Create Resume Kegiatan';
$this->params['breadcrumbs'][] = ['label' => 'Resume Kegiatan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
