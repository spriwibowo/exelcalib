<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id_client
 * @property int $id_entity 0 maka non faskes ( 100 dan 1000 ), xx rs/pkm/kli/lab
 * @property int $tipe 100 dinas, 1000 pt, 1 rs, 2 pkm, 3 klinik, 4 labkes
 * @property int|null $rating
 * @property string|null $tgl_start muali jadi client
 * @property string|null $tgl_last terakhir po
 * @property int|null $freq berapa kali
 * @property string|null $cleint_name kontak person
 * @property string|null $client_phone no telp
 * @property string|null $client_email
 * @property int|null $id_loc
 * @property string|null $client_address
 */
class ClientModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rating', 'tgl_start', 'tgl_last', 'freq', 'cleint_name', 'client_phone', 'client_email', 'id_loc', 'client_address'], 'default', 'value' => null],
            [['id_entity'], 'default', 'value' => 0],
            [['id_entity', 'tipe', 'rating', 'freq', 'id_loc'], 'integer'],
            [['tipe'], 'required'],
            [['tgl_start', 'tgl_last'], 'safe'],
            [['cleint_name', 'client_phone', 'client_email', 'client_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_client' => 'Id Client',
            'id_entity' => 'Id Entity',
            'tipe' => 'Tipe',
            'rating' => 'Rating',
            'tgl_start' => 'Tgl Start',
            'tgl_last' => 'Tgl Last',
            'freq' => 'Freq',
            'cleint_name' => 'Cleint Name',
            'client_phone' => 'Client Phone',
            'client_email' => 'Client Email',
            'id_loc' => 'Id Loc',
            'client_address' => 'Client Address',
        ];
    }

}
