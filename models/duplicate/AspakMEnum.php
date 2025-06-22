<?php

namespace app\models\duplicate;

use Yii;

/**
 * This is the model class for table "aspak_m_enum".
 *
 * @property int $id_satuan
 * @property string $enum_name
 * @property float|null $enum_value nilai
 * @property string|null $enum_term
 * @property string|null $enum_json { type:0,1,10 : unknow, room, mix }
 */
class AspakMEnum extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspak_m_enum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enum_term', 'enum_json'], 'default', 'value' => null],
            [['enum_value'], 'default', 'value' => 0],
            [['enum_value'], 'number'],
            [['enum_json'], 'string'],
            [['enum_name'], 'string', 'max' => 50],
            [['enum_term'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_satuan' => 'Id Satuan',
            'enum_name' => 'Enum Name',
            'enum_value' => 'Enum Value',
            'enum_term' => 'Enum Term',
            'enum_json' => 'Enum Json',
        ];
    }

}
