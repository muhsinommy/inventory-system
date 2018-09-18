<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\ProductCategory;
use app\models\Supplier;
use app\models\config\Status;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'product_id',
            [
                'attribute' => 'category',
                'value' => function ($model) {
                    return ProductCategory::findOne($model->category)->category_desc;
                }
            ],
            'details',
            [
                'attribute' => 'price',
                'value' => function ($model) {
                    return '<p class="pull-right label label-info">' . number_format($model->price, 2) . '/=</p>';
                },
                'format' => 'raw'
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
                'attribute' => 'status',
                'value' => function ($model) {
                    return Status::getStatuses()[$model->status];
                },
                'filter' => Status::getStatuses()
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
