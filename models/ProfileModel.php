<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id_prof
 * @property string|null $prof_name
 * @property string|null $prof_sign url image
 * @property string|null $prof_exp text deskripsi pengalaman
 * @property string|null $prof_comp text_deskripsi kompetensi
 * @property string|null $prof_img url image
 * @property string|null $prof_phone
 */
class ProfileModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prof_name', 'prof_sign', 'prof_exp', 'prof_comp', 'prof_img', 'prof_phone'], 'default', 'value' => null],
            [['prof_exp', 'prof_comp'], 'string'],
            [['prof_name', 'prof_sign', 'prof_img', 'prof_phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_prof' => 'Id Prof',
            'prof_name' => 'Prof Name',
            'prof_sign' => 'Prof Sign',
            'prof_exp' => 'Prof Exp',
            'prof_comp' => 'Prof Comp',
            'prof_img' => 'Prof Img',
            'prof_phone' => 'Prof Phone',
        ];
    }

}
