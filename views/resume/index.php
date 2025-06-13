<?php

use app\models\ResumeModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Resume Kegiatan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Resume Kegiatan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id_alat',
                'value' => 'alat_text',
                'label' => 'Nama Alat',
            ],
            'no_po',
            'nama_po',
            [
                'attribute' => 'tanggal_po',
                'format' => ['date', 'php:d-m-Y'],
            ],
            'jumlah',
            'jumlah_progress',
            //'jumlah_finish',
            //'jumlah_laik',
            //'jumlah_tidak',
            //'extra:ntext',
            //'id_po',
            [
                'class' => ActionColumn::className(),
                'template' => '{kalibrasi} {view} {update} {delete} ', // tambahkan nama action di template
                'urlCreator' => function ($action, ResumeModel $model, $key, $index, $column) {
                    if ($action === 'kalibrasi') {
                        return Url::toRoute(['job/create', 'id' => $model->id_resume]);
                    }
                    return Url::toRoute([$action, 'id_resume' => $model->id_resume]);
                },
                'buttons' => [
                    'kalibrasi' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-plus"></i>', $url, [
                            'title' => 'Tambah Kegiatan Kalibrasi',
                            'data-pjax' => '0',
                            'class' => 'btn btn-primary btn-sm'
                        ]);
                    },
                ],
            ]
            ,
        ],
    ]); ?>


</div>
