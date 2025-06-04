<?php

use yii\grid\GridView;
use yii\data\ArrayDataProvider;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ArrayDataProvider([
    'allModels' => [
        ['id' => 1, 'name' => 'User A'],
        ['id' => 2, 'name' => 'User B'],
    ],
    'pagination' => false,
]);

?>

<h2>Data Sample</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => ['id', 'name'],
]) ?>
