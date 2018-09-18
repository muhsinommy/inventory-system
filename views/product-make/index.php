<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\config\Country;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductMakeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Makes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-make-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product Make', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'make_id',
            'make_desc',
            [
                'attribute' => 'country',
                'value' => function ($model) {
                    return Country::findOne($model->country)->country_name;
                },
                'filter' => Country::getCountries()
            ],
            [
                'attribute' => 'logo',
                'value' => function ($model) {
                    return '<p class="pull-left"><image class="img thumbnail" style="width:50px;'
                            . ' height:50px" src="' . $model->getLogo() . '">'
                            . '</image>'
                            . '</p>';
                },
                'format' => 'raw'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
