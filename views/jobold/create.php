<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\JobModel $model */

$this->title = 'Create Kegiatan Kalibrasi';
$this->params['breadcrumbs'][] = ['label' => 'Kegiatan Kalibrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
