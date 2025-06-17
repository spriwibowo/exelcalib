<?php

use app\models\TemplateModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pustaka MK';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?=  GridView::widget([
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
                    'attribute' => 'status',
                    'value' => 'status_text',
                    'label' => 'Status',
                ],
                [
                    'attribute' => 'file',
                    'label' => 'File',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $url = Url::to("@web/" . $model->file, true);
                        return Html::a(
                            '<i class="bi bi-download"></i> Download', // icon (opsional, butuh Bootstrap Icons)
                            $url,
                            [
                                'class' => 'btn btn-sm btn-outline-primary',
                                'download' => basename($model->file),
                                'target' => '_blank',
                            ]
                        );
                    },
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
