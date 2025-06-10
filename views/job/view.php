<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\JobModel $model */

$this->title = $model->id_job;
$this->params['breadcrumbs'][] = ['label' => 'Kegiatan Kalibrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="job-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_job' => $model->id_job], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_job' => $model->id_job], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_job',
            'id_alat',
            'id_template',
            'no_po',
            'nama_po',
            'tanggal_po',
            'id_user',
            'id_jadwal',
            'tgl_kalibrasi',
            'extra:ntext',
            'id_po',
            'file:ntext',
            'laik',
            'ketidakpastian',
            'stt_laik',
            'serial',
            'merk',
            'tipe',
            'id_resume',
        ],
    ]) ?>

</div>
