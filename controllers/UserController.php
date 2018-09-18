<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends MainController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update', 'view', 'delete', 'index', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'view', 'delete', 'index', 'logout'],
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User();
        $model_profile = new \app\models\Profile();
        //Get Request type to be loaded by all two models
        $data = Yii::$app->request->post();
        $isAjax = Yii::$app->request->isAjax; //Stores boolean value for Ajax request
        /* Use Ajax to Validate email and phone */
        if ($isAjax && $model_profile->load($data)) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model_profile);
        }
        
        
        if ($model->load($data) && $model_profile->load($data) && $model_profile->validate()) {
            /*             * * Provide Other Data Related to $model ** */
            /* Working on username */
            $model->user_name = $model->user_name == 'email' ? $model_profile->email : $model_profile->phone;
            $model->password = $model->generateDefaultPassword(); //Works on @password and @password_hash
            $model->access_token = Yii::$app->getSecurity()->generateRandomString();
            $model->auth_key = Yii::$app->getSecurity()->generateRandomString();
            $model->registered_by = Yii::$app->user->id;
            /* Working on $model_profile */
            if ($model->save()) {
                /* Save details for a profile */
                $model_profile->user_id = $model->user_id;
                /*                 * Grant Accesses to the user ($model)* */
                $model->setGrantedAccess();
            }
            if ($model_profile->save()) {
                //Send Flash Message and Redirect to Update Page
                $message = "Account for " . $model_profile->getFullName() . " has been successfully created!";
                \Yii::$app->getSession()->setFlash('message_updated', $message);
                return $this->redirect(['update', 'id' => $model->user_id]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'model_profile' => $model_profile
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model_profile = \app\models\Profile::findOne($model->user_id);

        $data = Yii::$app->request->post();

        //Read old role
        $old_role = $model->role;

        $isAjax = Yii::$app->request->isAjax; //Stores boolean value for Ajax request
        /* Use Ajax to Validate email and phone */
        if ($isAjax && $model_profile->load($data)) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model_profile);
        }

        if ($model->load($data) && $model_profile->load($data)) {

            //Set date_updated and updated_by attributes
            //Set default time zone to match Tanzanian Time zone
            date_default_timezone_set('Africa/Dar_es_Salaam');
            $model->date_updated = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->id;
            if ($model->save() && $model_profile->save()) {
                //Check if User has changed role
                if ($model->role !== $old_role):
                    //Update Granted Access
                    $model->updateGrantedAccess();
                endif;
                $message = 'Details for ' . $model_profile->getFullName() . ' have been successfully updated!';
                Yii::$app->getSession()->setFlash('message_updated', $message);
                return $this->redirect(['update', 'id' => $model->user_id]);
            }
        }

        return $this->render('update', [
                    'model' => $model,
                    'model_profile' => $model_profile
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect(['/site/login']);
    }

    /**
     * Resets user password
     * @id is user_id
     * * */
    public function actionResetPassword($id) {
        $user = $this->findModel($id);
        $user->password = $user->resetPassword();
        $user->save();
        Yii::$app->getSession()->setFlash('message_updated', 'Password for ' . $user->getUserProfile()->getFullName() . ' has been successfully rest!');
        return $this->redirect(['index']);
    }

    //Updates User password
    public function actionUpdatePassword($id) {

        $model = new \app\models\PasswordUpdator();
        $user = $this->findModel($id);
        $model->curr_checker = $user->password;
        $model->username = $user->user_name;

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $user->password = \Yii::$app->getSecurity()->generatePasswordHash($model->new_pass);
                $user->password_hash = $user->password;
                $user->save();
                $message = 'Your password has been successfully, updated!';
                Yii::$app->getSession()->setFlash('message_updated', $message);
                return $this->redirect(['/profile/update', 'id' => $id]);
            }
        }

        return $this->render('pass_update', [
                    'model' => $model,
                    'id' => $id
        ]);
    }

    //Renders Reported Issues Page
    public function actionReportedIssues() {
        return $this->render('reported_issues');
    }

}
