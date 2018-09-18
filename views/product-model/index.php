<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\ProductMake;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-model-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Model', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'model_id',
            [
                'attribute' => 'make',
                'value' => function ($model) {
                    return ProductMake::findOne($model->make)->make_desc;
                },
                'filter' => ProductMake::getMakes()
            ],
            'model_desc',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
