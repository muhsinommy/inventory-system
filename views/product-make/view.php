<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\config\Country;

/* @var $this yii\web\View */
/* @var $model app\models\ProductMake */

$this->title = $model->make_desc;
$this->params['breadcrumbs'][] = ['label' => 'Product Makes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-make-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->make_id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->make_id], [
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
            [
                'attribute' => 'logo',
                'value' => function ($model) {
                    return '<p class="pull-left"><image class="img thumbnail" style="width:120px;'
                            . ' height:120px" src="' . $model->getLogo() . '">'
                            . '</image>'
                            . '</p>';
                },
                'format' => 'raw'
            ],
            // 'make_id',
            'make_desc',
            [
                'attribute' => 'country',
                'value' => function ($model) {
                    return Country::findOne($model->country)->country_name;
                }
            ]
        ],
    ])
    ?>

</div>
