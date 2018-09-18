<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ProductCategory;
use app\models\config\Status;
use app\models\Supplier;
use app\models\ProductMake;
use app\models\ProductModel;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->details;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->product_id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->product_id], [
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
        'model' => $details,
        'attributes' => [
            [
                'attribute' => 'make',
                'value' => function ($model) {
                    return ProductMake::findOne($model->make)->make_desc;
                }
            ],
            [
                'attribute' => 'model',
                'value' => function ($model) {
                    return ProductModel::findOne((int) $model->model)->model_desc;
                }
            ]
        ]
    ]) .
    '<hr>'
                    . '<label>Other Details</label>' .
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'product_id',
            [
                'attribute' => 'category',
                'value' => function ($model) {
                    return ProductCategory::findOne($model->category)->category_desc;
                }
            ],
            'details',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Status::getStatuses()[$model->status];
                },
                'filter' => Status::getStatuses()
            ],
            [
                'attribute' => 'supplier',
                'value' => function ($model) {
                    return Supplier::findOne($model->supplier)->name;
                }
            ],
            [
                'attribute' => 'is_purchased',
                'label' => 'Source',
                'value' => function ($model) {
                    return Status::getShipmentStatus()[$model->is_purchased];
                },
                'filter' => Status::getShipmentStatus()
            ],
            [
                'attribute' => 'price',
                'value' => function ($model) {
                    return '<p class="pull-left label label-info">' . number_format($model->price, 2) . '/=</p>';
                },
                'format' => 'raw'
            ],
        ],
    ])
    ?>

</div>
