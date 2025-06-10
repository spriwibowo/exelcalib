<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TemplateModel $model */

$this->title = $model->id_template;
$this->params['breadcrumbs'][] = ['label' => 'Template MK', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="template-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_template' => $model->id_template], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_template' => $model->id_template], [
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
            'id_template',
            'id_alat',
            'nama',
            'file:ntext',
            'extra:ntext',
            'laik_sheet',
            'laik_row',
            'ketidakpastian_sheet',
            'ketidakpastian_row',
            'status',
            'keterangan:ntext',
        ],
    ]) ?>

</div>
