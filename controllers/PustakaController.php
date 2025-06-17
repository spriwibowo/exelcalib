<?php

namespace app\controllers;

use app\models\TemplateModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
use app\models\helper\HelperData;
/**
 * TemplateController implements the CRUD actions for TemplateModel model.
 */
class PustakaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'], // hanya untuk user yang login
                        ],
                    ],
                ],
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

}
