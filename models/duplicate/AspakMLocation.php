<?php

namespace app\models\duplicate;

use Yii;

/**
 * This is the model class for table "aspak_m_location".
 *
 * @property int $id_loc
 * @property string|null $loc_name
 * @property int $loc_parent
 * @property string|null $loc_path
 * @property int|null $loc_type
 * @property int|null $loc_level
 * @property int|null $loc_order
 * @property string|null $loc_code
 * @property string|null $loc_mendagri kode mendagri
 */
class AspakMLocation extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspak_m_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loc_name', 'loc_type', 'loc_level', 'loc_code', 'loc_mendagri'], 'default', 'value' => null],
            [['loc_parent'], 'default', 'value' => 0],
            [['loc_path'], 'default', 'value' => ','],
            [['loc_order'], 'default', 'value' => 1000],
            [['loc_parent', 'loc_type', 'loc_level', 'loc_order'], 'integer'],
            [['loc_name', 'loc_mendagri'], 'string', 'max' => 100],
            [['loc_path'], 'string', 'max' => 40],
            [['loc_code'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_loc' => 'Id Loc',
            'loc_name' => 'Loc Name',
            'loc_parent' => 'Loc Parent',
            'loc_path' => 'Loc Path',
            'loc_type' => 'Loc Type',
            'loc_level' => 'Loc Level',
            'loc_order' => 'Loc Order',
            'loc_code' => 'Loc Code',
            'loc_mendagri' => 'Loc Mendagri',
        ];
    }

}
