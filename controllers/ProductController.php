<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ProductDetails;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller {

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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {

        $details = ProductDetails::findOne($id);

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'details' => $details
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Product();
        $details = new ProductDetails();
        $data = Yii::$app->request->post();
        
        if ($model->load($data) && $details->load($data)) {


            if ($model->save()) {

                $details->product_id = $model->product_id;


                if ($details->save()) {

                    Yii::$app->getSession()->setFlash('message_updated', 'Product has been successfully Created!');

                    return $this->redirect(['view', 'id' => $model->product_id]);
                }
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'details' => $details
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $details = ProductDetails::findOne($id);

        $data = Yii::$app->request->post();

        if ($model->load($data) && $details->load($data) && $model->save() && $details->save()) {

            Yii::$app->getSession()->setFlash('message_updated', 'Product has been successfully Updated!');

            return $this->redirect(['view', 'id' => $model->product_id]);
        }

        return $this->render('update', [
                    'model' => $model,
                    'details' => $details
        ]);
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //Returns Product Models associated with Product Make whose with
    //id = $id
    public function actionDetails($make_id) {

        $models = \app\models\ProductModel::find()->where([
                    'make' => $make_id
                ])->all();
        $res = '';
        foreach ($models as $model) {
            $res .= '<option value=' . $model->model_id . '>' . $model->model_desc . '</option>';
        }
        return $res;
    }

}
