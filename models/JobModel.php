<?php

namespace app\models;
use PhpOffice\PhpSpreadsheet\IOFactory;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property int $id_job
 * @property int|null $id_alat
 * @property int|null $id_template
 * @property string|null $no_po
 * @property string|null $nama_po
 * @property string|null $tanggal_po
 * @property int|null $id_user
 * @property int|null $id_jadwal
 * @property string|null $tgl_kalibrasi
 * @property string|null $extra
 * @property int|null $id_po
 * @property string|null $file
 * @property string|null $laik
 * @property string|null $ketidakpastian
 * @property int|null $stt_laik
 * @property string|null $serial
 * @property string|null $merk
 * @property string|null $tipe
 * @property int|null $id_resume
 */
class JobModel extends \yii\db\ActiveRecord
{

    public $uploadfile;

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
            [['id_alat', 'id_template','serial','merk','tipe','no_po','nama_po','tanggal_po'], 'required'],
            [['id_alat', 'id_template', 'no_po', 'nama_po', 'tanggal_po', 'id_user', 'id_jadwal', 'tgl_kalibrasi', 'extra', 'id_po', 'file', 'laik', 'ketidakpastian', 'stt_laik', 'serial', 'merk', 'tipe', 'id_resume'], 'default', 'value' => null],
            [['id_alat', 'id_template', 'id_user', 'id_jadwal', 'id_po', 'stt_laik', 'id_resume'], 'integer'],
            [['tanggal_po', 'tgl_kalibrasi'], 'safe'],
            [['extra', 'file'], 'string'],
            [['uploadfile'], 'file', 
                'skipOnEmpty' => function ($model) {
                    return !$model->isNewRecord;
                }, 
                'extensions' => ['xls', 'xlsx'], 
                'wrongExtension' => 'Hanya file Excel (.xls, .xlsx) yang diizinkan.'
            ],
            [['no_po', 'nama_po', 'laik', 'ketidakpastian', 'serial', 'merk', 'tipe'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_job' => 'Id Job',
            'id_alat' => 'Nama Alat',
            'id_template' => 'Nama Template',
            'no_po' => 'No Po',
            'nama_po' => 'Nama Po',
            'tanggal_po' => 'Tanggal Po',
            'id_user' => 'Id User',
            'id_jadwal' => 'Id Jadwal',
            'tgl_kalibrasi' => 'Tgl Kalibrasi',
            'extra' => 'Extra',
            'id_po' => 'Id Po',
            'file' => 'File',
            'laik' => 'Laik',
            'ketidakpastian' => 'Ketidakpastian',
            'stt_laik' => 'Stt Laik',
            'serial' => 'Serial',
            'merk' => 'Merk',
            'tipe' => 'Tipe',
            'id_resume' => 'Id Resume',
        ];
    }


    public function preload($model){

        if($model){
            $this->attributess = $model->attributess;
        }

        if(empty($this->id_user)){
            $this->id_user = Yii::$app->user->id;
        }
        if(empty($this->tanggal_po)){
            $this->tanggal_po = date('Y-m-d');
        }
        if(empty($this->tgl_kalibrasi)){
            $this->tgl_kalibrasi = date('Y-m-d');
        }

        return $this;

    }

    public function newsave($uploadedFile){
        $result = array(
            'status'=>false,
            'message'=>'Gagal Menyimpan Data'
        );

        $template = TemplateModel::findOne(['id_template' => $this->id_template]);
        if(empty($template)){
            $result['message'] = 'Template Tidak Valid';
            return $result;
        } 


        $fileName = uniqid('job_') . '.' . $uploadedFile->extension;
        $relativePath = 'uploads/jobs/' . $fileName;
        $fullPath = Yii::getAlias('@webroot/' . $relativePath);

        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0775, true);
        }

        if ($uploadedFile->saveAs($fullPath)) {
            $this->file = $relativePath;
            try {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fullPath);
                $sheet = $spreadsheet->getSheetByName($template->laik_sheet);
                if ($sheet) {
                    $value = $sheet->getCell($template->laik_row)->getCalculatedValue();
                    $this->laik = strtoupper($value);

                    if(in_array($this->laik,array('LAIK','LAYAK','LAIK PAKAI'))){
                        $this->stt_laik = 1;
                    }else{
                        $this->stt_laik = 0;
                    }

                } else {
                    $result['message'] = "Sheet '{$template->laik_sheet}' tidak ditemukan.";
                    return $result;
                }
            } catch (\Throwable $e) {
                $result['message'] = "Gagal membaca file Excel: " . $e->getMessage();
                return $result;
            }
        } else {
            $result['message'] = 'Gagal menyimpan file.';
            return $result;
        }
        

        if(!empty($this->tgl_kalibrasi)){
            $this->tgl_kalibrasi =  date('Y-m-d',strtotime($this->tgl_kalibrasi));
        }

        if(!empty($this->tanggal_po)){
            $this->tanggal_po =  date('Y-m-d',strtotime($this->tanggal_po));
        }

        if(empty($this->id_resume)){
            $resume = ResumeModel::findOne(['no_po'=>$this->no_po,'nama_po'=>$this->nama_po,'id_alat'=>$this->id_alat]);
            if(empty($resume)){
                $resume = new ResumeModel();
                $resume->no_po = $this->no_po;
                $resume->nama_po = $this->nama_po;
                $resume->tanggal_po = date('Y-m-d',strtotime($this->tanggal_po));
                $resume->id_alat = $this->id_alat;
                $resume->save();
            }
            $this->id_resume = $resume->id_resume;
        }else{
            $resume = ResumeModel::findOne(['id_resume'=>$this->id_resume]);
        }


        $this->save();

        if($this->isNewRecord){
            $resume->jumlah_progress++;
            if($resume->jumlah <= $resume->jumlah_progress){
                $resume->jumlah = $resume->jumlah_progress;
            }
        }
        

        $resume->save();
        $result['status'] = true;
        $result['message']= "Data berhasil disimpan. Nilai dari Excel: {$this->laik}";

        return $result;

    }

}
