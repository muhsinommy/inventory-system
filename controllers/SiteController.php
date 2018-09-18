<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Json;
use app\models\User;
class SiteController extends Controller {

    public function beforeAction($action) {

        if (parent::beforeAction($action)) {

            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', 'contact', 'about', 'login'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'contact'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['contact', 'about', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
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

    /**
     * {@inheritdoc}
     */
    public function actions() {
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

    
    public function actionTest(){
         $user = User::findOne(1);
        $user->password = Yii::$app->getSecurity()->generatePasswordHash('taba8440');
        var_dump($user->save());die;
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        
        
       // Yii::$app->user->logout();
       
        //$user = User::findOne(1);
        //$user->password = Yii::$app->getSecurity()->generatePasswordHash('taba8440');
        //var_dump($user->save());die;
        
        //User is authenticated, redirect user to index
        if (!Yii::$app->user->isGuest) {
            $user = User::findOne(\Yii::$app->user->id);
            if ($user->getRoleCode() === \app\models\Role::PROPERTY_VALUER){
                $this->layout = 'no_layout';
            }
            
            
            //User is authenticated but has inactive account, redirect to inactive page
            if (!\app\models\User::findOne(\Yii::$app->user->id)->isActive()) {

                $issue = new \app\models\Issue();
                $issue->user_id = \Yii::$app->user->id;
                $issue->action = '/' . $this->getRoute();
                $issue->viewed = \app\models\Issue::NOT_VIEWED;
                $issue->description = \app\models\Issue::ERROR_INACTIVE_ACCOUNT;
                $issue->save();

                return $this->redirect(['inactive', 'id' => \Yii::$app->user->id]);
            }
            return $this->render('index', [
                        'user' => \app\models\User::findOne(Yii::$app->user->id)
            ]);
        } else {
            //User is not authenticated, redirect to login page
            return $this->redirect(['login']);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {

       // $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {

            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        // $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout(true);

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $this->layout = 'login';
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
    public function actionAbout() {
        return $this->render('about');
    }

    ####To be documented later

    public function actionCheckActiveItem($id) {
        Yii::$app->getSession()->set('item_id', $id);
        return 'set';
    }

    /**
     * Called When Inactive User Logs in
     * @id is user_id
     * * */
    public function actionInactive($id) {
        $this->layout = 'login';
        //Find model associated with user
        $user = \app\models\User::findOne($id);
        return $this->render('inactive', [
                    'user' => $user
        ]);
    }

    //Updates Default Year
    public function actionUpdateSettings($year) {
        $settings = \app\models\settings\Settings::findOne(['userid' => \Yii::$app->user->id]);
        if ($settings === null):
            $settings = new \app\models\settings\Settings();
        endif;
        $settings->userid = \Yii::$app->user->id;
        $settings->active_year = $year;
        if ($settings->save()):
            if ($year == 0):
                $message = 'All Details are Displayed as per All Time';
            else:
                $message = 'All Details are Displayed as per Year: ' . $year;
            endif;

            \Yii::$app->getSession()->setFlash('message_updated', $message);
            //return $this->redirect(['index']);
            return $this->redirect(Yii::$app->request->referrer);
        endif;
    }

    public function actionSync() {
        return $this->redirect(Yii::$app->request->referrer);
    }

}
