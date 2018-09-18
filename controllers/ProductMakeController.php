<?php

namespace app\controllers;

use Yii;
use app\models\ProductMake;
use app\models\ProductMakeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductMakeController implements the CRUD actions for ProductMake model.
 */
class ProductMakeController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductMake models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductMakeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductMake model.
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
     * Creates a new ProductMake model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProductMake();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->make_id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductMake model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->make_id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductMake model.
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
     * Finds the ProductMake model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductMake the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProductMake::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates Logo Picture for the make --> model
     * * */
    public function actionUploadLogo($id) {
        //Get Instance of the Uploaded File
        $uploaded_file = $_FILES['product_logo'];
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
        $path = 'uploads/make_logo/' . 'logo_for_' . $id . '.' . $ext;
        // return json_encode(['error' => $uploaded['tmp_name']]);
        //Upload
        if (move_uploaded_file($uploaded_file['tmp_name'], $path)) {
            $uploaded = true;
        }
        //Update User Profile details
        if ($uploaded) {
            $make = $this->findModel($id);
            $make->logo = $path;
            if ($make->save()) {
                //Set a Flash Message
                Yii::$app->getSession()->setFlash('message_updated', 'Product Make Logo has beeen successfully updated! ');
                //echo json_decode(['uploaded' => $path]);
                return $this->redirect(['update', 'id' => $id]);
            }
        }
    }

}
