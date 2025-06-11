<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use app\models\duplicate\AspakNewAlat;
use app\models\TemplateModel;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\JobModel $model */
/** @var yii\widgets\ActiveForm $form */

$alatText = ''; // default
if ($model->id_alat) {
    $alat = TemplateModel::findOne(['id_alat'=>$model->id_alat]);
    if ($alat) {
        $alatText = $alat->alat_text;
        $alatText = Html::encode($alatText);
    }
    
}

$templateText = '';
if($model->id_template){
    $template = TemplateModel::findOne(['id_template'=>$model->id_template]);
    if ($template) {
        $templateText = $template->nama;
        $templateText = Html::encode($templateText);

        $model->id_alat = $template->id_alat;
        $alatText = $template->alat_text;
        $alatText = Html::encode($alatText);
        
    }
}

?>

<div class="job-model-form">

    <?php $form = ActiveForm::begin([
        'id' => 'job-form',
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

    <?= $form->field($model, 'id_template')->dropDownList([], [
        'id' => 'id_template',
        'prompt' => 'Pilih Template...'
    ]) ?>

    <?php if(empty($model->id_resume)):?>   
    <?= $form->field($model, 'no_po')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_po')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_po')->widget(DatePicker::class, [
        'dateFormat' => 'dd-MM-yyyy',
        'options' => ['class' => 'form-control'],
    ]) ?>

    <?php endif;?>


    <?= $form->field($model, 'serial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'merk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_kalibrasi')->widget(DatePicker::class, [
        'dateFormat' => 'dd-MM-yyyy',
        'options' => ['class' => 'form-control'],
    ]) ?>


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

    <div class="form-group row">
        <div class="offset-sm-3 col-sm-6">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$searchAlat = Url::to(['template/searchalat']);
$searchTemplate = Url::to(['template/searchtemplate']);
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


$('#id_alat').on('change', function () {
    $('#id_template').val(null).trigger('change');
});

$('#id_template').select2({
    placeholder: "Cari Template...",
    allowClear: true,
    width: '100%',
    ajax: {
        url: '{$searchTemplate}',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                id_alat: $('#id_alat').val() || null // tambahkan fallback
            };
        },
        processResults: function (data) {
            return {
                results: data.items.map(function (item) {
                    return {
                        id: item.id,
                        name: item.name,
                        keterangan: item.keterangan,
                        text: item.name
                    };
                })
            };
        }
    },
    templateResult: function (data) {
        if (!data.id) {
            return data.text;
        }
        return $('<div>').append('<div>' + data.name + '</div>');
    },
    templateSelection: function (data) {
        return data.text;
    },
    escapeMarkup: function (markup) {
        return markup;
    }
}).on('select2:open', function () {
    $('.select2-search__field').addClass('form-control');
}).on('select2:opening', function (e) {
    const idAlat = $('#id_alat').val();
    if (!idAlat) {
        alert('Silakan pilih alat terlebih dahulu.');
        e.preventDefault();
    }
});


// Tambah class form-control ke elemen select2
$('#id_template').next('.select2-container').find('.select2-selection--single').addClass('form-control');


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

<?php if ($model->id_template && !empty($templateText)): ?>
    <?php
    $jsTemplate = <<<JS
    let selectedTemplate = new Option("{$templateText}", "{$model->id_template}", true, true);
    $('#id_template').append(selectedTemplate).trigger('change');
    JS;
    $this->registerJs($jsTemplate);
    ?>
<?php endif; ?>
