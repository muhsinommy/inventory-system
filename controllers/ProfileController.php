<?php

namespace app\controllers;

use Yii;
use app\models\Profile;
use app\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends MainController {

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
                'only' => ['create', 'update', 'view', 'index', 'delete', 'upload-profile-picture'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'view', 'index', 'delete', 'upload-profile-picture'],
                        'roles' => ['@'],
                    ]
                ],
            ]
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
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
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Profile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        #Make sure Only Logged in user accesses this action by checking
        #If ($id == Yii::$user->id), if no throw an Exception...
        if ($id != Yii::$app->user->id):
            throw new \yii\web\ForbiddenHttpException('Sorry, you can not access this account!');
        endif;
        #Find user with user_id == $id
        $model = $this->findModel($id);
        //Get User Model
        $model_user = \app\models\User::findOne($model->user_id);
        //Store old password
        $old_password = $model_user->password;
        //Clear password attribute
        $model_user->password = null;
        //Posted data
        $posted_data = Yii::$app->request->post();
        $isAjax = Yii::$app->request->isAjax; //Stores boolean value for Ajax request
        /* Use Ajax to Validate email and phone */
        if ($isAjax && $model->load($posted_data)) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load($posted_data) && $model_user->load($posted_data)) {
            if ($model_user->password == null) {
                //Retain the Original password
                $model_user->password = $old_password;
            } else {
                //Apply Logic of saving new password
                $model_user->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model_user->password);
                $model_user->password = $model_user->password_hash;
            }
            if ($model->save() && $model_user->save()) {
                Yii::$app->getSession()->setFlash('message_updated', 'Your profile has been successfully updated');
                return $this->redirect(['update', 'id' => $model->user_id]);
            }
        }

        return $this->render('update', [
                    'model' => $model,
                    'model_user' => $model_user
        ]);
    }

    /**
     * Deletes an existing Profile model.
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
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*
     * Uploads Profile picture of the Current User
     * Logged into the System @param integer $id, is
     * user_id
     *    */

    public function actionUploadProfilePicture($id) {
        //Get Instance of the Uploaded File
        $uploaded_file = $_FILES['user_icon'];
        //Check if File exists
        if (empty($uploaded_file)) {
            //Returns Json encoded Error message
            return json_encode('error', 'No picture has been chosen!');
        }
        //Holds final status
        $uploaded = false;
        //Read file name
        $file_name = $uploaded_file['name'];
        //File extension
        $ext = pathinfo($file_name)['extension'];
        //Path to file storage
        $path = 'uploads/profile_picture/' . 'icon_for_' . $id . '.' . $ext;
        // return json_encode(['error' => $uploaded['tmp_name']]);
        //Upload
        if (move_uploaded_file($uploaded_file['tmp_name'], $path)) {
            $uploaded = true;
        }
        //Update User Profile details
        if ($uploaded) {
            $profile = $this->findModel($id);
            $profile->profile_picture = $path;
            if ($profile->save()) {
                //Set a Flash Message
                Yii::$app->getSession()->setFlash('message_updated', 'Your profile picture has beeen successfully updated! ');
                //echo json_decode(['uploaded' => $path]);
                return $this->redirect(['update', 'id' => $id]);
            }
        }
    }

    //Returns Array Of Districts
    //@id is region_id
    public function actionGetDistricts($id) {
        $districts = \app\models\District::getDistricts($id);
        $data = '';
        foreach ($districts as $district):
            $data .= '<option value=' . $district->district_id . '>' . $district->district_name . '</option>';
        endforeach;
        return $data;
    }

    //Removes User Profile Picture, @id is user_id
    public function actionRemoveProfilePicture($id) {
        if ($id != Yii::$app->user->id):
            throw new \yii\web\ForbiddenHttpException('Sorry, you can not access this account!');
        endif;
        $profile = $this->findModel($id);
        if ($profile->profile_picture != null):
            if (unlink($profile->profile_picture)):
                $profile->profile_picture = null;
                $profile->save();
                $message = 'Profile Picture has been successfully  removed!';
                Yii::$app->getSession()->setFlash('message_updated', $message);
            endif;
        endif;
        return $this->redirect(['update', 'id' => $id]);
    }
}
