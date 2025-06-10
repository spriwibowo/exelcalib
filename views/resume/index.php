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

            'id_resume',
            'id_alat',
            'no_po',
            'nama_po',
            'tanggal_po',
            //'jumlah',
            //'jumlah_progress',
            //'jumlah_finish',
            //'jumlah_laik',
            //'jumlah_tidak',
            //'extra:ntext',
            //'id_po',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ResumeModel $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_resume' => $model->id_resume]);
                 }
            ],
        ],
    ]); ?>


</div>
