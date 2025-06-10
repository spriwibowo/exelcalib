<?php

namespace app\controllers;

use app\models\ResumeModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * ResumeController implements the CRUD actions for ResumeModel model.
 */
class ResumeController extends Controller
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
     * Lists all ResumeModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ResumeModel::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id_resume' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ResumeModel model.
     * @param int $id_resume Id Resume
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_resume)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_resume),
        ]);
    }

    /**
     * Creates a new ResumeModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ResumeModel();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_resume' => $model->id_resume]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ResumeModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_resume Id Resume
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_resume)
    {
        $model = $this->findModel($id_resume);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_resume' => $model->id_resume]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ResumeModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_resume Id Resume
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_resume)
    {
        $this->findModel($id_resume)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ResumeModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_resume Id Resume
     * @return ResumeModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_resume)
    {
        if (($model = ResumeModel::findOne(['id_resume' => $id_resume])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
