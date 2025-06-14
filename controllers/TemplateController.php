<?php

namespace app\controllers;

use app\models\TemplateModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
use app\models\helper\HelperData;
/**
 * TemplateController implements the CRUD actions for TemplateModel model.
 */
class TemplateController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all TemplateModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TemplateModel::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id_template' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TemplateModel model.
     * @param int $id_template Id Template
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_template)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_template),
        ]);
    }

    /**
     * Creates a new TemplateModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TemplateModel();

        // Untuk validasi AJAX (live form validation)
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost) {
            
            $model->load(Yii::$app->request->post());
            $uploadedFile = UploadedFile::getInstance($model, 'uploadfile');

            // Cek validasi wajib file hanya saat create
            if ($model->isNewRecord && empty($uploadedFile)) {
                $model->addError('uploadfile', 'File wajib diunggah.');
            }

            if ($model->validate()) {
                $valid_file = false;
                if ($uploadedFile) {
                    $isExcel = HelperData::IsExcelFile($uploadedFile);
                    if($isExcel){
                        $fileName = uniqid('template_') . '.' . $uploadedFile->extension;
                        $relativePath = 'uploads/templates/' . $fileName;
                        $fullPath = Yii::getAlias('@webroot/' . $relativePath);

                        if (!is_dir(dirname($fullPath))) {
                            mkdir(dirname($fullPath), 0775, true);
                        }

                        if ($uploadedFile->saveAs($fullPath)) {
                            $model->file = $relativePath;

                            // Baca file Excel
                            try {
                                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fullPath);
                                $sheet = $spreadsheet->getSheetByName($model->laik_sheet);
                                if ($sheet) {
                                    $value = $sheet->getCell($model->laik_row)->getValue();
                                    Yii::$app->session->setFlash('success', "Data berhasil disimpan");
                                    $valid_file = true;
                                } else {
                                    Yii::$app->session->setFlash('warning', "Sheet '{$model->laik_sheet}' tidak ditemukan.");
                                }
                            } catch (\Throwable $e) {
                                Yii::$app->session->setFlash('error', "Gagal membaca file Excel: " . $e->getMessage().' <br/>File Excel tidak boleh diproteksi dengan password.');
                            }
                        } else {
                            Yii::$app->session->setFlash('error', "Gagal menyimpan file.");
                        }
                    }else{
                        Yii::$app->session->setFlash('error', "Format File Tidak Sesuai.");
                    }
                    

                    
                }

                if ($valid_file && $model->save(false)) {
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing TemplateModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_template Id Template
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_template)
    {
        $model = $this->findModel($id_template);
        $oldFilePath = $model->file; // simpan path lama

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $uploadedFile = UploadedFile::getInstance($model, 'uploadfile');

            if ($uploadedFile) {
                $valid_file = false;

                $isExcel = HelperData::IsExcelFile($uploadedFile);
                    if($isExcel){
                        $fileName = uniqid('template_') . '.' . $uploadedFile->extension;
                        $relativePath = 'uploads/templates/' . $fileName;
                        $fullPath = Yii::getAlias('@webroot/' . $relativePath);

                        if (!is_dir(dirname($fullPath))) {
                            mkdir(dirname($fullPath), 0775, true);
                        }

                        if ($uploadedFile->saveAs($fullPath)) {
                            $model->file = $relativePath;

                            // Proses Excel jika file baru diunggah
                            try {
                                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fullPath);
                                $sheet = $spreadsheet->getSheetByName($model->laik_sheet);
                                if ($sheet) {
                                    $value = $sheet->getCell($model->laik_row)->getValue();
                                    Yii::$app->session->setFlash('success', "Data berhasil disimpan dan File berhasil diganti");
                                    $valid_file = true;
                                } else {
                                    Yii::$app->session->setFlash('warning', "Sheet '{$model->laik_sheet}' tidak ditemukan.");
                                }
                            } catch (\Throwable $e) {
                                Yii::$app->session->setFlash('error', "Gagal membaca file Excel: " . $e->getMessage().' <br/>File Excel tidak boleh diproteksi dengan password.');
                            }
                        } else {
                            Yii::$app->session->setFlash('error', "Gagal menyimpan file.");
                        }
                    }else{
                        Yii::$app->session->setFlash('error', "Format File Tidak Sesuai.");
                    }
            } else {

                // Tidak ada file baru diupload, gunakan yang lama
                $valid_file = true;
                $model->file = $oldFilePath;
            }

            if ($valid_file && $model->save(false)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing TemplateModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_template Id Template
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_template)
    {
        $this->findModel($id_template)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TemplateModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_template Id Template
     * @return TemplateModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_template)
    {
        if (($model = TemplateModel::findOne(['id_template' => $id_template])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSearchalat() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $params = Yii::$app->request->get();
        $q = isset($params['q']) ? $params['q'] : '';
        $data = TemplateModel::SearchAlat($q);
        
        return ['items' => $data];
    }

    public function actionSearchtemplate() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $params = Yii::$app->request->get();
        $id_alat = isset($params['id_alat']) ? $params['id_alat'] : '';
        $data = TemplateModel::SearchTemplate($id_alat);
        
        return ['items' => $data];
    }
}
