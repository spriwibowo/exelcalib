<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "po".
 *
 * @property int $id_po
 * @property string|null $no_po
 * @property string|null $tgl_po
 * @property int $id_client
 * @property int|null $tipe 0 non faskes aspak ( 100 , 1000 ), 1 rs, 2 pkm, 3 klinik, 4 labkes
 * @property int $id_offer 0 bukan dari penawaran
 * @property string|null $lokasi {json}, jika rs, isi idrs, jika bukan search, jika tanpa {}
 * @property float|null $nilai
 * @property int|null $waktu hari, di conversi ke tanggal
 */
class PoModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'po';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_po', 'tgl_po', 'lokasi', 'nilai', 'waktu'], 'default', 'value' => null],
            [['id_offer'], 'default', 'value' => 0],
            [['tipe'], 'default', 'value' => 1],
            [['tgl_po'], 'safe'],
            [['id_client', 'tipe', 'id_offer', 'waktu'], 'integer'],
            [['lokasi'], 'string'],
            [['nilai'], 'number'],
            [['no_po'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_po' => 'Id Po',
            'no_po' => 'No Po',
            'tgl_po' => 'Tgl Po',
            'id_client' => 'Id Client',
            'tipe' => 'Tipe',
            'id_offer' => 'Id Offer',
            'lokasi' => 'Lokasi',
            'nilai' => 'Nilai',
            'waktu' => 'Waktu',
        ];
    }

}
