<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_lk".
 *
 * @property int $id_lk
 * @property int $id_job id kegiatan kelibrasi berhubungan dngn PO
 * @property int|null $id_alat
 * @property int|null $id_template
 * @property int|null $id_user
 * @property string $nama_petugas terisi otomatis akibat user akun
 * @property string|null $ruangan ruangan pelayanan, nanti dibutuhkan saat sync aspak
 * @property string|null $lokasi ruangan fisik, nanti dibutuhkan saat sync aspak
 * @property string|null $tgl_lk
 * @property string|null $extra catatan pada monitoring aspak
 * @property string|null $file link original file downloadnya
 * @property int|null $stt_laik
 * @property string|null $laik
 * @property string|null $ketidakpastian
 * @property string|null $serial
 * @property string|null $merk
 * @property string|null $tipe
 * @property string|null $metode isian free text, ini ada di isian monitoring
 * @property string|null $qr isian angka/0-9,A-F 
 * @property string|null $link_sertifikat tgl sertifkat company terisi nanti (auto)
 * @property string|null $tgl_sertifikat tgl sertifkat company terisi nanti (auto) saat supervisi akan terkirim ke aspak
 * @property string|null $sertifikat no sertifkat company terisi nanti (auto) saat supervisi  akan terkirim ke aspak
 * @property int $user_sup user id yang supervisi
 * @property int $user_lab user penanggungjawab lab
 */
class JobLkModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_lk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alat', 'id_template', 'id_user', 'ruangan', 'lokasi', 'tgl_lk', 'extra', 'file', 'stt_laik', 'laik', 'ketidakpastian', 'serial', 'merk', 'tipe', 'metode', 'qr', 'link_sertifikat', 'tgl_sertifikat', 'sertifikat'], 'default', 'value' => null],
            [['user_lab'], 'default', 'value' => 0],
            [['id_job', 'nama_petugas'], 'required'],
            [['id_job', 'id_alat', 'id_template', 'id_user', 'stt_laik', 'user_sup', 'user_lab'], 'integer'],
            [['tgl_lk', 'link_sertifikat', 'tgl_sertifikat'], 'safe'],
            [['extra', 'file'], 'string'],
            [['nama_petugas'], 'string', 'max' => 300],
            [['ruangan', 'lokasi', 'laik', 'ketidakpastian', 'serial', 'merk', 'tipe', 'qr', 'sertifikat'], 'string', 'max' => 255],
            [['metode'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_lk' => 'Id Lk',
            'id_job' => 'Id Job',
            'id_alat' => 'Id Alat',
            'id_template' => 'Id Template',
            'id_user' => 'Id User',
            'nama_petugas' => 'Nama Petugas',
            'ruangan' => 'Ruangan',
            'lokasi' => 'Lokasi',
            'tgl_lk' => 'Tgl Lk',
            'extra' => 'Extra',
            'file' => 'File',
            'stt_laik' => 'Stt Laik',
            'laik' => 'Laik',
            'ketidakpastian' => 'Ketidakpastian',
            'serial' => 'Serial',
            'merk' => 'Merk',
            'tipe' => 'Tipe',
            'metode' => 'Metode',
            'qr' => 'Qr',
            'link_sertifikat' => 'Link Sertifikat',
            'tgl_sertifikat' => 'Tgl Sertifikat',
            'sertifikat' => 'Sertifikat',
            'user_sup' => 'User Sup',
            'user_lab' => 'User Lab',
        ];
    }

}
