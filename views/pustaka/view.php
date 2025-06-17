<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TemplateModel $model */

$this->title = $model->id_template;
$this->params['breadcrumbs'][] = ['label' => 'Pustaka MK', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="template-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
