<?php

namespace app\models;

use Yii;
use app\models\duplicate\AspakNewAlat;
/**
 * This is the model class for table "template".
 *
 * @property int $id_template
 * @property int|null $id_alat
 * @property string|null $nama
 * @property string|null $file
 * @property string|null $extra
 * @property string|null $laik_sheet
 * @property string|null $laik_row
 * @property string|null $ketidakpastian_sheet
 * @property string|null $ketidakpastian_row
 * @property int|null $status
 * @property string|null $keterangan
 */
class TemplateModel extends \yii\db\ActiveRecord
{

    public $uploadfile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alat', 'nama','laik_sheet','laik_row'], 'required'],
            [['id_alat', 'nama', 'file', 'extra', 'laik_sheet', 'laik_row', 'ketidakpastian_sheet', 'ketidakpastian_row', 'keterangan'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['id_alat', 'status'], 'integer'],
            [['uploadfile'], 'file', 
                'skipOnEmpty' => function ($model) {
                    return !$model->isNewRecord;
                }, 
                'extensions' => ['xls', 'xlsx'], 
                'wrongExtension' => 'Hanya file Excel (.xls, .xlsx) yang diizinkan.'
            ],
            [['file','extra', 'keterangan'], 'string'],
            [['nama', 'laik_sheet', 'laik_row', 'ketidakpastian_sheet', 'ketidakpastian_row'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_template' => 'Id Template',
            'id_alat' => 'Nama Alat',
            'nama' => 'Nama Template',
            'file' => 'File',
            'extra' => 'Extra',
            'laik_sheet' => 'Laik Sheet',
            'laik_row' => 'Laik Cell & Row',
            'ketidakpastian_sheet' => 'Ketidakpastian Sheet',
            'ketidakpastian_row' => 'Ketidakpastian Row',
            'status' => 'Status',
            'keterangan' => 'Keterangan',
        ];
    }

    public function getAlat() {
        return $this->hasOne(AspakNewAlat::class, ['id_alat' => 'id_alat'])
                        ->from(AspakNewAlat::tableName() . ' alat');
    }

    public function getAlat_text(){
        if($this->alat){
            return $this->alat->alat_code.' - '.$this->alat->alat_name;
        }
        return '-';
    }

    public static function ListStatus(){
        return [
            1=>'Aktif',
            0=>'Tidak Aktif'
        ];
    }

    public function getStatus_text() {
        $list = self::ListStatus();
        return isset($list[$this->status])?$list[$this->status]:'-';
    }

}
