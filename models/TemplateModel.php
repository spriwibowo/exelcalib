<?php

namespace app\models;

use Yii;
use app\models\duplicate\AspakNewAlat;
/**
 * This is the model class for table "template".
 *
 * @property int $id_template
 * @property int|null $id_alat
 * @property string|null $nama
 * @property string|null $file
 * @property string|null $extra
 * @property string|null $laik_sheet
 * @property string|null $laik_row
 * @property string|null $ketidakpastian_sheet
 * @property string|null $ketidakpastian_row
 * @property int|null $status
 * @property string|null $keterangan
 */
class TemplateModel extends \yii\db\ActiveRecord
{

    public $uploadfile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alat', 'nama','laik_sheet','laik_row'], 'required'],
            [['id_alat', 'nama', 'file', 'extra', 'laik_sheet', 'laik_row', 'ketidakpastian_sheet', 'ketidakpastian_row', 'keterangan'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['id_alat', 'status'], 'integer'],
            [['uploadfile'], 'file', 
                'skipOnEmpty' => function ($model) {
                    return !$model->isNewRecord;
                }, 
                'extensions' => ['xls', 'xlsx'], 
                'wrongExtension' => 'Hanya file Excel (.xls, .xlsx) yang diizinkan.'
            ],
            [['file','extra', 'keterangan'], 'string'],
            [['nama', 'laik_sheet', 'laik_row', 'ketidakpastian_sheet', 'ketidakpastian_row'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_template' => 'Id Template',
            'id_alat' => 'Nama Alat',
            'nama' => 'Nama Template',
            'file' => 'File',
            'extra' => 'Extra',
            'laik_sheet' => 'Laik Sheet',
            'laik_row' => 'Laik Cell & Row',
            'ketidakpastian_sheet' => 'Ketidakpastian Sheet',
            'ketidakpastian_row' => 'Ketidakpastian Row',
            'status' => 'Status',
            'keterangan' => 'Keterangan',
        ];
    }

    public function getAlat() {
        return $this->hasOne(AspakNewAlat::class, ['id_alat' => 'id_alat'])
                        ->from(AspakNewAlat::tableName() . ' alat');
    }

    public function getAlat_text(){
        if($this->alat){
            return $this->alat->alat_code.' - '.$this->alat->alat_name;
        }
        return '-';
    }

    public static function ListStatus(){
        return [
            1=>'Aktif',
            0=>'Tidak Aktif'
        ];
    }

    public function getStatus_text() {
        $list = self::ListStatus();
        return isset($list[$this->status])?$list[$this->status]:'-';
    }

    public static function SearchAlat($q = '',$all=0) {
        $data = array();
        $limit = 100;
        $query = self::find();
        $query->from(self::tableName() . ' t')
                ->joinWith(['alat.parent.grandparent.kelompok']);

        if (!empty($q)) {
            $keyword = trim($q);
            $query->andWhere("alat.alat_name LIKE '%{$keyword}%' or alat.alat_code LIKE '%{$keyword}%' or alat.sinonim LIKE '%{$keyword}%'");
        }

        if(!$all){
            $query->andWhere(['t.status'=>1]);
        }

        $query->groupBy(['t.id_alat']);

        $result = $query->orderBy('alat.alat_name', 'asc')
                ->limit($limit)
                ->all();

        foreach ($result as $item) {
            $alat = $item->alat;
            $data[] = array(
                'id' => $alat->id_alat,
                'name' => $alat->alat_name,
                'code' => (empty($alat->childs))?strval($alat->alat_code):'',
                'sinonim' => $alat->sinonim,
                'id_parent' => $alat->parent_id,
                'desc' => $alat->alat_ket,
                'keterangan' => !empty($alat->parent) ? $alat->parent->alat_name:'-',
                'link'=>(count($alat->childs) > 0) ? Url::to(['payload/subalat', 'id_parent' => $alat->id_alat, 'param' => 1]) : '-'
            );
        }

        return $data;
    }

    public static function SearchTemplate($id_alat=0) {

        $data = array();
        if(!empty($id_alat)){

            $limit = 100;
            $query = self::find();
            $query->from(self::tableName() . ' t')
                    ->joinWith(['alat']);

            $query->andWhere(['t.status'=>1,'t.id_alat'=>$id_alat]);

            $result = $query->orderBy('t.nama', 'asc')
                    ->limit($limit)
                    ->all();

            foreach ($result as $item) {
                $data[] = array(
                    'id' => $item->id_template,
                    'name' => $item->nama,
                    'keterangan' => $item->keterangan
                );
            }
        }
        
        return $data;
    }

}
