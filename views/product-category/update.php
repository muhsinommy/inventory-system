<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductCategory */

$this->title = 'Update Product Category: ' . $model->category_desc;
$this->params['breadcrumbs'][] = ['label' => 'Product Categories', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->category_id, 'url' => ['view', 'id' => $model->category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-category-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
