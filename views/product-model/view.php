<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ProductMake;

/* @var $this yii\web\View */
/* @var $model app\models\ProductModel */

$this->title = $model->model_desc;
$this->params['breadcrumbs'][] = ['label' => 'Product Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-model-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->model_id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->model_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'model_id',
            [
                'attribute' => 'make',
                'value' => function ($model) {
                    return ProductMake::findOne($model->make)->make_desc;
                }
            ],
            [

                'attribute' => 'model_id',
                'label' => 'Make Logo',
                'value' => function ($model) {
                    return '<p class="pull-left"><image class="img thumbnail" style="width:120px;'
                            . ' height:120px" src="' . ProductMake::findOne($model->make)->getLogo() . '">'
                            . '</image>'
                            . '</p>';
                },
                'format' => 'raw',
            ],
            'model_desc',
        ],
    ])
    ?>

</div>
