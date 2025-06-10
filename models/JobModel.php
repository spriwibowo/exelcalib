<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property int $id_job
 * @property int|null $id_alat
 * @property int|null $id_template
 * @property string|null $no_po
 * @property string|null $nama_po
 * @property string|null $tanggal_po
 * @property int|null $id_user
 * @property int|null $id_jadwal
 * @property string|null $tgl_kalibrasi
 * @property string|null $extra
 * @property int|null $id_po
 * @property string|null $file
 * @property string|null $laik
 * @property string|null $ketidakpastian
 * @property int|null $stt_laik
 * @property string|null $serial
 * @property string|null $merk
 * @property string|null $tipe
 * @property int|null $id_resume
 */
class JobModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alat', 'id_template', 'no_po', 'nama_po', 'tanggal_po', 'id_user', 'id_jadwal', 'tgl_kalibrasi', 'extra', 'id_po', 'file', 'laik', 'ketidakpastian', 'stt_laik', 'serial', 'merk', 'tipe', 'id_resume'], 'default', 'value' => null],
            [['id_alat', 'id_template', 'id_user', 'id_jadwal', 'id_po', 'stt_laik', 'id_resume'], 'integer'],
            [['tanggal_po', 'tgl_kalibrasi'], 'safe'],
            [['extra', 'file'], 'string'],
            [['no_po', 'nama_po', 'laik', 'ketidakpastian', 'serial', 'merk', 'tipe'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_job' => 'Id Job',
            'id_alat' => 'Id Alat',
            'id_template' => 'Id Template',
            'no_po' => 'No Po',
            'nama_po' => 'Nama Po',
            'tanggal_po' => 'Tanggal Po',
            'id_user' => 'Id User',
            'id_jadwal' => 'Id Jadwal',
            'tgl_kalibrasi' => 'Tgl Kalibrasi',
            'extra' => 'Extra',
            'id_po' => 'Id Po',
            'file' => 'File',
            'laik' => 'Laik',
            'ketidakpastian' => 'Ketidakpastian',
            'stt_laik' => 'Stt Laik',
            'serial' => 'Serial',
            'merk' => 'Merk',
            'tipe' => 'Tipe',
            'id_resume' => 'Id Resume',
        ];
    }

}
