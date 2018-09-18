<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductModel */

$this->title = 'Update Product Model: ' . $model->model_id;
$this->params['breadcrumbs'][] = ['label' => 'Product Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->model_id, 'url' => ['view', 'id' => $model->model_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-model-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
