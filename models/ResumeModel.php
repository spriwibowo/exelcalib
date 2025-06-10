<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resume".
 *
 * @property int $id_resume
 * @property int|null $id_alat
 * @property string|null $no_po
 * @property string|null $nama_po
 * @property string|null $tanggal_po
 * @property int|null $jumlah
 * @property int|null $jumlah_progress
 * @property int|null $jumlah_finish
 * @property int|null $jumlah_laik
 * @property int|null $jumlah_tidak
 * @property string|null $extra
 * @property int|null $id_po
 */
class ResumeModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alat', 'no_po', 'nama_po', 'tanggal_po', 'jumlah_tidak', 'extra', 'id_po'], 'default', 'value' => null],
            [['jumlah_laik'], 'default', 'value' => 0],
            [['id_alat', 'jumlah', 'jumlah_progress', 'jumlah_finish', 'jumlah_laik', 'jumlah_tidak', 'id_po'], 'integer'],
            [['extra'], 'string'],
            [['no_po', 'nama_po', 'tanggal_po'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_resume' => 'Id Resume',
            'id_alat' => 'Id Alat',
            'no_po' => 'No Po',
            'nama_po' => 'Nama Po',
            'tanggal_po' => 'Tanggal Po',
            'jumlah' => 'Jumlah',
            'jumlah_progress' => 'Jumlah Progress',
            'jumlah_finish' => 'Jumlah Finish',
            'jumlah_laik' => 'Jumlah Laik',
            'jumlah_tidak' => 'Jumlah Tidak',
            'extra' => 'Extra',
            'id_po' => 'Id Po',
        ];
    }

}
