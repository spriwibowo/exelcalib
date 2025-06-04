<?php

namespace app\models\duplicate;

use yii\helpers\Url;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "aspak_new_alat".
 *
 * @property int $id_alat
 * @property string|null $alat_name
 * @property string|null $alat_code
 * @property int|null $parent_id
 * @property string|null $alat_ket
 * @property string|null $alat_path
 * @property string|null $sinonim
 * @property string|null $kode
 * @property int|null $filter
 * @property int|null $wajibkalibrasi default tidak
 * @property int|null $durasi 700 hari
 */
class AspakNewAlat extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'aspak_new_alat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['parent_id', 'filter', 'wajibkalibrasi', 'durasi'], 'integer'],
            [['alat_name', 'alat_code', 'alat_path', 'kode'], 'string', 'max' => 255],
            [['alat_ket', 'sinonim'], 'string', 'max' => 5000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id_alat' => 'Id Alat',
            'alat_name' => 'Alat Name',
            'alat_code' => 'Alat Code',
            'parent_id' => 'Parent ID',
            'alat_ket' => 'Alat Ket',
            'alat_path' => 'Alat Path',
            'sinonim' => 'Sinonim',
            'kode' => 'Kode',
            'filter' => 'Filter',
            'wajibkalibrasi' => 'Wajibkalibrasi',
            'durasi' => 'Durasi',
        ];
    }

    public function getParent() {
        return $this->hasOne(AspakNewAlat::class, ['id_alat' => 'parent_id'])
                        ->from(self::tableName() . ' parent');
    }

    public function getGrandparent() {
        return $this->hasOne(AspakNewAlat::class, ['id_alat' => 'parent_id'])
                        ->from(self::tableName() . ' grandparent');
    }
    public function getKelompok() {
        return $this->hasOne(AspakNewAlat::class, ['id_alat' => 'parent_id'])
                        ->from(self::tableName() . ' kelompok');
    }

    public function getChilds() {
        return $this->hasMany(AspakNewAlat::class, ['parent_id' => 'id_alat']);
    }

    public static function LoadList($parent = 0, $params = 2, $all=0) {
        $data = array();
        $query = self::find();
        $query->from(self::tableName() . ' t')
                ->joinWith(['parent'])
                ->orderBy('t.alat_code', 'asc');

        if ($params == 2) {
            $query->where(['t.parent_id' => $parent])->orWhere(['parent.parent_id' => $parent]);
        } else {
            $query->where(['t.parent_id' => $parent]);
        }

        if(!$all){
            $query->where(['<>', 't.filter', -1]);
        }

        $result = $query->all();


        if ($params == 2) {
            $array_data = array();
            foreach ($result as $key => $item) {
                $array_data[$item->parent_id][] = array(
                    'id' => $item->id_alat,
                    'name' => $item->alat_name,
                    'code' => $item->alat_code,
                    'sinonim' => $item->sinonim,
                    'id_parent' => $item->parent_id,
                    'desc' => $item->alat_ket,
                    'jml_sub' => count($item->childs),
                    'link' => (count($item->childs) > 0) ? Url::to(['payload/subalat', 'id_parent' => $item->id_alat, 'param' => 1]) : '-'
                );
            }

            foreach ($array_data[$parent] as $key => $isi) {
                $subitem = isset($array_data[$isi['id']]) ? $array_data[$isi['id']] : array();

                $data[] = array(
                    'id' => $isi['id'],
                    'name' => $isi['name'],
                    'code' => $isi['code'],
                    'sinonim' => $isi['sinonim'],
                    'id_parent' => $isi['id_parent'],
                    'desc' => $isi['desc'],
                    'jml_sub' => $isi['jml_sub'],
                    'subitem' => $subitem
                );
            }
        } else {
            foreach ($result as $key => $item) {

                $data[] = array(
                    'id' => $item->id_alat,
                    'name' => $item->alat_name,
                    'code' => $item->alat_code,
                    'sinonim' => $item->sinonim,
                    'id_parent' => $item->parent_id,
                    'desc' => $item->alat_ket,
                    'jml_sub' => count($item->childs),
                    'link' => (count($item->childs) > 0) ? Url::to(['payload/subalat', 'id_parent' => $item->id_alat, 'param' => 2]) : '-'
                );
            }
        }



        return $data;
    }

    public static function SearchAlat($q = '',$all=0) {
        $data = array();
        $limit = 100;
        $query = self::find();
        $query->from(self::tableName() . ' t')
                ->joinWith(['parent.grandparent.kelompok']);

        if (!empty($q)) {
            $keyword = trim($q);
            $query->andWhere("t.alat_name LIKE '%{$keyword}%' or t.alat_code LIKE '%{$keyword}%' or t.sinonim LIKE '%{$keyword}%'");
        }

        if(!$all){
            $query->andWhere(['<>', 't.filter', -1]);
        }

        $query->andWhere("kelompok.parent_id=0");

        $result = $query->orderBy('t.alat_name', 'asc')
                ->limit($limit)
                ->all();

        foreach ($result as $item) {
            $data[] = array(
                'id' => $item->id_alat,
                'name' => $item->alat_name,
                'code' => (empty($item->childs))?strval($item->alat_code):'',
                'sinonim' => $item->sinonim,
                'id_parent' => $item->parent_id,
                'desc' => $item->alat_ket,
                'keterangan' => !empty($item->parent) ? $item->parent->alat_name:'-',
                'link'=>(count($item->childs) > 0) ? Url::to(['payload/subalat', 'id_parent' => $item->id_alat, 'param' => 1]) : '-'
            );
        }

        return $data;
    }

}
