<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProductMake */

$this->title = 'Create Product Make';
$this->params['breadcrumbs'][] = ['label' => 'Product Makes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-make-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
