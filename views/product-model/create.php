<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProductModel */

$this->title = 'Create Product Model';
$this->params['breadcrumbs'][] = ['label' => 'Product Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-model-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
