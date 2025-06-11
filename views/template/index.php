<?php

use app\models\TemplateModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Template MK';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Template MK', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_template',
            // 'id_alat',
            [
                'attribute' => 'id_alat',
                'value' => 'alat_text',
                'label' => 'Nama Alat',
            ],
            'nama',
            [
                'attribute' => 'file',
                'label' => 'File',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(
                        basename($model->file),
                        Url::to("@web/" . $model->file, true),
                        ['target' => '_blank']
                    );
                },
            ],
            [
                'attribute' => 'status',
                'value' => 'status_text',
                'label' => 'Status',
            ],
            // 'extra:ntext',
            //'laik_sheet',
            //'laik_row',
            //'ketidakpastian_sheet',
            //'ketidakpastian_row',
            //'status',
            //'keterangan:ntext',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TemplateModel $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_template' => $model->id_template]);
                 }
            ],
        ],
    ]); ?>


</div>
