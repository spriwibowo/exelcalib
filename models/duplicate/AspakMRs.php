<?php

namespace app\models\duplicate;

use Yii;

/**
 * This is the model class for table "aspak_m_rs".
 *
 * @property int $id_rs
 * @property string $datepost
 * @property string $rs_code
 * @property string $rs_name
 * @property string $rs_address
 * @property int $rs_bed jumlah tempat tidur
 * @property int $rs_masterplan 0 Tidak ada, 1 Ada
 * @property float $rs_bor persentase nilai bor 0 s/d 100
 * @property int $rs_akreditasi 0 belum, 1 sudah
 * @property string|null $rs_telp
 * @property string|null $rs_fax
 * @property int|null $id_tipe jenis RS, dari table kategori, tipe
 * @property int|null $id_kelas kelas RS ke table kategori, kelas
 * @property int|null $id_pemilik pemilik rs, ke table kategori , pemilik
 * @property int|null $id_loc
 * @property int|null $poned 1 mampu poned
 * @property string|null $reg_number
 * @property float|null $lat
 * @property float|null $lon
 * @property string|null $rs_satset
 */
class AspakMRs extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspak_m_rs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipe', 'id_kelas', 'id_pemilik', 'id_loc', 'reg_number', 'lat', 'lon', 'rs_satset'], 'default', 'value' => null],
            [['rs_fax'], 'default', 'value' => ''],
            [['poned'], 'default', 'value' => 0],
            [['datepost'], 'safe'],
            [['rs_address'], 'required'],
            [['rs_address'], 'string'],
            [['rs_bed', 'rs_masterplan', 'rs_akreditasi', 'id_tipe', 'id_kelas', 'id_pemilik', 'id_loc', 'poned'], 'integer'],
            [['rs_bor', 'lat', 'lon'], 'number'],
            [['rs_code'], 'string', 'max' => 20],
            [['rs_name'], 'string', 'max' => 250],
            [['rs_telp', 'reg_number'], 'string', 'max' => 255],
            [['rs_fax'], 'string', 'max' => 50],
            [['rs_satset'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_rs' => 'Id Rs',
            'datepost' => 'Datepost',
            'rs_code' => 'Rs Code',
            'rs_name' => 'Rs Name',
            'rs_address' => 'Rs Address',
            'rs_bed' => 'Rs Bed',
            'rs_masterplan' => 'Rs Masterplan',
            'rs_bor' => 'Rs Bor',
            'rs_akreditasi' => 'Rs Akreditasi',
            'rs_telp' => 'Rs Telp',
            'rs_fax' => 'Rs Fax',
            'id_tipe' => 'Id Tipe',
            'id_kelas' => 'Id Kelas',
            'id_pemilik' => 'Id Pemilik',
            'id_loc' => 'Id Loc',
            'poned' => 'Poned',
            'reg_number' => 'Reg Number',
            'lat' => 'Lat',
            'lon' => 'Lon',
            'rs_satset' => 'Rs Satset',
        ];
    }

}
