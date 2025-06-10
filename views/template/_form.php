<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\duplicate\AspakNewAlat;
use app\models\TemplateModel;

// ...
$alatText = ''; // default
if ($model->id_alat) {
    $alat = AspakNewAlat::findOne($model->id_alat);
    if ($alat) {
        $alatText = $alat->alat_code . ' - ' . $alat->alat_name;
        $alatText = Html::encode($alatText);
    }
    
}


?>

    


<style>
    .select2-selection--single.form-control {
        height: calc(2.5rem + 2px); /* sesuaikan dengan input height kamu */
        padding: 0.375rem 0.75rem;
        line-height: 1.5;
    }

</style>
<div class="template-model-form">

    <?php $form = ActiveForm::begin([
        'id' => 'template-form',
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal'],
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'layout' => 'horizontal', // penting di bootstrap5
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-3',
                'wrapper' => 'col-sm-6',
                'error' => 'col-sm-3',
                'hint' => '',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'id_alat')->dropDownList([], [
        'id' => 'id_alat',
        'prompt' => 'Pilih Alat...'
    ]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uploadfile')->fileInput([
        'accept' => '.xls,.xlsx',
        'id' => 'file-excel'
    ])->label('File Excel' . (!$model->isNewRecord && $model->file ? ' (biarkan kosong jika tidak diganti)' : '')) ?>

    <?php if (!$model->isNewRecord && $model->file): ?>
        <div class="form-group row">
            <div class="offset-sm-3 col-sm-6">
                <p class="form-text">
                    File saat ini: 
                    <a href="<?= Url::to('@web/' . $model->file, true) ?>" target="_blank">
                        <?= basename($model->file) ?>
                    </a>
                </p>
            </div>
        </div>
    <?php endif; ?>


    <?= $form->field($model, 'laik_sheet')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'laik_row')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        TemplateModel::ListStatus(), 
        ['prompt' => 'Pilih Status']) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group row">
        <div class="offset-sm-3 col-sm-6">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$searchAlat = Url::to(['site/searchalat']);
$js = <<<JS
$('#id_alat').select2({
    placeholder: "Cari Alat...",
    allowClear: true,
    width: '100%',
    ajax: {
        url: '{$searchAlat}',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return { q: params.term };
        },
        processResults: function (data) {
            return {
                results: data.items.map(function (item) {
                    return {
                        id: item.id,
                        code: item.code,
                        name: item.name,
                        keterangan: item.keterangan,
                        text: item.code + ' - ' + item.name // default value
                    };
                })
            };
        }
    },
    templateResult: function (data) {
        if (!data.id) {
            return data.text;
        }
        return $('<div>')
            .append('<div>' + data.code + ' - ' + data.name + '</div>')
            .append('<div class="text-muted small"><i>' + (data.keterangan || '') + '</i></div>');
    },
    templateSelection: function (data) {
        return data.code ? data.code + ' - ' + data.name : data.text;
    },
    escapeMarkup: function (markup) {
        return markup;
    }
}).on('select2:open', function () {
    $('.select2-search__field').addClass('form-control');
});

// Tambah class form-control ke elemen select2
$('#id_alat').next('.select2-container').find('.select2-selection--single').addClass('form-control');



$('#file-excel').on('change', function() {
    var allowedExtensions = /(\.xls|\.xlsx)$/i;
    var filePath = $(this).val();
    if (!allowedExtensions.exec(filePath)) {
        alert('Hanya file Excel (.xls, .xlsx) yang diperbolehkan.');
        $(this).val('');
    }
});
JS;
$this->registerJs($js);
?>

<?php if ($model->id_alat && !empty($alatText)): ?>
    <?php
    $jsSelected = <<<JS
    let selectedOption = new Option("{$alatText}", "{$model->id_alat}", true, true);
    $('#id_alat').append(selectedOption).trigger('change');
    JS;
    $this->registerJs($jsSelected);
    ?>
<?php endif; ?>



