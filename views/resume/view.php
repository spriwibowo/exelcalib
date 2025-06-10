<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ResumeModel $model */

$this->title = $model->id_resume;
$this->params['breadcrumbs'][] = ['label' => 'Resume Kegiatan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="resume-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_resume' => $model->id_resume], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_resume' => $model->id_resume], [
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
            'id_resume',
            'id_alat',
            'no_po',
            'nama_po',
            'tanggal_po',
            'jumlah',
            'jumlah_progress',
            'jumlah_finish',
            'jumlah_laik',
            'jumlah_tidak',
            'extra:ntext',
            'id_po',
        ],
    ]) ?>

</div>
