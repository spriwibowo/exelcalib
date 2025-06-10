<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TemplateModel $model */

$this->title = 'Update Template MK: ' . $model->id_template;
$this->params['breadcrumbs'][] = ['label' => 'Template MK', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_template, 'url' => ['view', 'id_template' => $model->id_template]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="template-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
