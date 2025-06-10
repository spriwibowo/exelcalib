<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TemplateModel $model */

$this->title = 'Create Template MK';
$this->params['breadcrumbs'][] = ['label' => 'Template MK', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
