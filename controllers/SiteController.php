<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Categories;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionIndex($id = null)
    {
        $category = null;
        $parents = null;

        $categories = Categories::find()->select(['id', 'title', 'lft', 'rgt', 'lvl'])->asArray()->orderBy(['tree'=> SORT_ASC, 'lft' => SORT_ASC])->all();
        
        if($id){
            $category = Categories::findOne($id);
            $parents = $category->parents()->asArray()->all();
        }

        return $this->render('index', [
            'category_active' => $category,
            'parents' => $parents, 
            'categories' => $categories
        ]);
    }

    public function actionKartik(){
        return $this->render('kartik');
    }

    public function actionGen(){
        for($a = 1; $a <= 10; $a++){
            $root = new Categories(['title' => 'Категория '.$a]);
            $root->makeRoot();

            for($b = 1; $b <= 5; $b++){
                $node_1 = new Categories(['title' => 'Подкатегория ' . $a .'-' . $b]);
                $node_1->appendTo($root);
                
                for($c = 1; $c <= 10; $c++){
                    $node_2 = new Categories(['title' => 'Подкатегория ' . $a . '-' . $b . '-' . $c]);
                    $node_2->appendTo($node_1);

                    for($d = 1; $d <= 10; $d++){
                        $node_3 = new Categories(['title' => 'Подкатегория ' . $a . '-' . $b . '-' . $c . '-' . $d]);
                        $node_3->appendTo($node_2);
                    }
                }
            }
        }

        return $this->redirect(['site/index']);
    }

    public function actionMove($id, $after_id){
        $category = Categories::findOne($id);
        $category_after = Categories::findOne($after_id);

        $category->insertAfter($category_after);
        return $this->redirect(['site/index']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
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
}
