<?php

use app\models\JobModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kegiatan Kalibrasi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Kegiatan Kalibrasi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_job',
            'id_alat',
            'id_template',
            'no_po',
            'nama_po',
            //'tanggal_po',
            //'id_user',
            //'id_jadwal',
            //'tgl_kalibrasi',
            //'extra:ntext',
            //'id_po',
            //'file:ntext',
            //'laik',
            //'ketidakpastian',
            //'stt_laik',
            //'serial',
            //'merk',
            //'tipe',
            //'id_resume',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, JobModel $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_job' => $model->id_job]);
                 }
            ],
        ],
    ]); ?>


</div>
