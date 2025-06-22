<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property int $id_job
 * @property string|null $tanggal_job
 * @property int $tipe 0 bukan faskes aspak, 1 rs, 2 pkm, 3 klinik, 4 lab
 * @property int $id_rs 0 bukan aspak_rs
 * @property int $id_po 0 non PO
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
            [['tanggal_job'], 'default', 'value' => null],
            [['id_po'], 'default', 'value' => 0],
            [['tanggal_job'], 'safe'],
            [['tipe', 'id_rs', 'id_po'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_job' => 'Id Job',
            'tanggal_job' => 'Tanggal Job',
            'tipe' => 'Tipe',
            'id_rs' => 'Id Rs',
            'id_po' => 'Id Po',
        ];
    }

}
