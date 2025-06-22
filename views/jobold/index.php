<?php

use app\models\JobOldModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\LinkPager;

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

    <?=  GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
    
                // 'id_job',
                [
                    'attribute' => 'id_alat',
                    'value' => 'alat_text',
                    'label' => 'Nama Alat',
                ],
                [
                    'attribute' => 'id_template',
                    'value' => 'template_text',
                    'label' => 'Nama Template',
                ],
                'no_po',
                'nama_po',
                //'tanggal_po',
                //'id_user',
                //'id_jadwal',
                [
                    'attribute' => 'tgl_kalibrasi',
                    'format' => ['date', 'php:d-m-Y'],
                ],
                //'extra:ntext',
                //'id_po',
                //'file:ntext',
                'laik',
                //'ketidakpastian',
                //'stt_laik',
                //'serial',
                //'merk',
                //'tipe',
                //'id_resume',
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'template' => '{view} {update} {delete} {download}',
                    'urlCreator' => function ($action, JobOldModel $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id_job' => $model->id_job]);
                    },
                    'buttons' => [
                        'download' => function ($url, $model, $key) {
                            $url = Url::to("@web/" . $model->file, true);
                            return Html::a(
                                '<i class="fa fa-download"></i>',
                                $url,
                                [
                                    'class' => '',
                                    'download' => basename($model->file),
                                    'target' => '_blank',
                                    'title' => 'Download file',
                                    'data-pjax' => '0',
                                ]
                            );
                        },
                    ],
                ],
            ],
            'pager' => [
                'class' => LinkPager::class,
                'options' => ['class' => 'pagination justify-content-center'], // Bootstrap 5
                'linkOptions' => ['class' => 'page-link'],
                'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                'activePageCssClass' => 'active',
                'disabledPageCssClass' => 'disabled',
                'maxButtonCount' => 5,
                'prevPageLabel' => '«',
                'nextPageLabel' => '»',
                'prevPageCssClass' => 'page-item',
                'nextPageCssClass' => 'page-item',
                'pageCssClass' => 'page-item',
            ],
            'tableOptions' => ['class' => 'table table-striped table-bordered'], // optional
        ]);
    ?>


</div>
