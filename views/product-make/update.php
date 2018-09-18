<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductMake */

$this->title = 'Update Product Make: ' . $model->make_desc;
$this->params['breadcrumbs'][] = ['label' => 'Product Makes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->make_desc, 'url' => ['view', 'id' => $model->make_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-make-update">
    <label>Make Logo</label>
    <br>
    <image src="<?= $model->getLogo() ?>" style="width: 120px; height: 120px" class="img img-thumbnail"/>
    <hr>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
