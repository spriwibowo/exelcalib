<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\duplicate\AspakNewAlat;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                // 'except' => ['login','createadmin'],
                'except' => ['login'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        return $this->render('list');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'open'; 
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    public function actionSearchalat() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $params = Yii::$app->request->get();
        $q = isset($params['q']) ? $params['q'] : '';
        $data = AspakNewAlat::SearchAlat($q);
        
        return ['items' => $data];
    }

    public function actionProfile()
    {
        $id = Yii::$app->user->id;
        $model = User::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Data pengguna tidak ditemukan.');
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }

        // Atur skenario agar validasi password opsional saat update
        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post())) {
           
            if (!$model->hasErrors() && $model->save(false)) {
                Yii::$app->session->setFlash('success', 'Profil berhasil diperbarui.');
                return $this->redirect(['profile']);
            }
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    // public function actionCreateadmin(){
    //     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //     $response = [
    //         'status'=>false,
    //         'message'=>'Admin Exist'
    //     ];
    //     $model = User::find()->where(['username' => 'admin'])->one();

    //     if(empty($model)){
    //         $model = new User();
    //         $model->username = 'admin';
    //         $model->email = 'admin@admin.com';
    //         $model->full_name = 'Administrator';
    //         $model->tipe = 1;
    //         $model->password = 'admin123';
    //         $model->created_at = time();
    //         $model->updated_at = time();

    //         if($model->save()){
    //             $response = [
    //                 'status'=>true,
    //                 'message'=>'Create Admin Success'
    //             ];
    //         }else{
    //             var_dump($model->getErrors());die();
    //         }

            
    //     }

    //     return $response;
    // }
}
