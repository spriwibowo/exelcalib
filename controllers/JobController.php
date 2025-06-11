<?php

namespace app\controllers;

use app\models\JobModel;
use app\models\ResumeModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Yii;

/**
 * JobController implements the CRUD actions for JobModel model.
 */
class JobController extends Controller
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
     * Lists all JobModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => JobModel::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id_job' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JobModel model.
     * @param int $id_job Id Job
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_job)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_job),
        ]);
    }

    /**
     * Creates a new JobModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id=0)
    {

        $resume = ResumeModel::findOne(['id_resume' => $id]);
        $model = new JobModel();
        $model->preload($resume);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }

        if ($this->request->isPost) {

            $model->load(Yii::$app->request->post());
            $uploadedFile = UploadedFile::getInstance($model, 'uploadfile');

            // Cek validasi wajib file hanya saat create
            if ($model->isNewRecord && empty($uploadedFile)) {
                $model->addError('uploadfile', 'File wajib diunggah.');
            }

            if ($model->validate()) {
                if ($uploadedFile) {
                    $result = $model->newsave($uploadedFile);
                    if($result['status']){
                        return $this->redirect(['view', 'id_job' => $model->id_job]);
                    }else{
                        Yii::$app->session->setFlash('error', $result['message']);
                    }
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
     * Updates an existing JobModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_job Id Job
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_job)
    {
        $model = $this->findModel($id_job);
        $oldFilePath = $model->file; // simpan path lama

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }

        if ($this->request->isPost) {

            $model->load(Yii::$app->request->post());
            $uploadedFile = UploadedFile::getInstance($model, 'uploadfile');

            // Cek validasi wajib file hanya saat create
            if ($model->isNewRecord && empty($uploadedFile)) {
                $model->addError('uploadfile', 'File wajib diunggah.');
            }

            if ($model->validate()) {
                if ($uploadedFile) {
                    $result = $model->newsave($uploadedFile);
                    if($result['status']){
                        return $this->redirect(['view', 'id_job' => $model->id_job]);
                    }else{
                        Yii::$app->session->setFlash('error', $result['message']);
                    }
                }
            }else{
                
            }
        } 

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing JobModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_job Id Job
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_job)
    {
        $this->findModel($id_job)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the JobModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_job Id Job
     * @return JobModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_job)
    {
        if (($model = JobModel::findOne(['id_job' => $id_job])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
