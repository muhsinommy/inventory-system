<?php

use app\models\settings\Settings;

$this->title = 'INVENTORY MANAGER DASHBOARD';
$this->params['breadcrumbs'][] = $this->title;

use app\models\Product;
use app\models\ProductModel;
use app\models\ProductCategory;
?>

<?php
//var_dump(\app\models\property\Property::getChartData());die;
?>
<div class="row">
    <div class="col-sm-6" style="display: none">
        <label class="label label-success">VALUE: TSHS <?= number_format(0, 2) ?></label>
    </div>
    <div class="col-sm-6" style="display: none">
        <label class="label label-success">TAX: TSHS <?= number_format(0, 2) ?></label>
    </div>
</div>

<div class="row">
    <!--Link to All Property-->
    <a href="<?= yii\helpers\Url::to(['product/index']) ?>" title="Show All Property">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="green">
                    <i class="material-icons">info</i>
                </div>
                <div class="card-content">
                    <p class="category">Products</p>
                    <h3 class="title">
                        <?= Product::getProductCount() ?>
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons text-success">add</i>
                        <a href="<?= yii\helpers\Url::to(['/product/create']) ?>">Register new Product...</a>

                    </div>
                </div>
            </div>
        </div>
    </a>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="<?= yii\helpers\Url::to(['/product-category/index']) ?>">
            <div class="card card-stats">
                <div class="card-header" data-background-color="green">
                    <i class="material-icons">transform</i>
                </div>
                <div class="card-content">
                    <p class="category">Product Categories</p>

                    <h3 class="title"><?= ProductCategory::getCount() ?></h3>

                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">remove_red_eye</i> 
                        <a href="<?= yii\helpers\Url::to(['/product-category/index']) ?>">View...</a>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="<?= yii\helpers\Url::to(['/product-make/index']) ?>">
            <div class="card card-stats">
                <div class="card-header" data-background-color="green">
                    <i class="material-icons">local_atm</i>
                </div>
                <div class="card-content">
                    <p class="category">Product Makes</p>
                    <h3 class="title"><?= app\models\ProductMake::getCount() ?></h3>

                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">remove_red_eye</i>
                        <a href="<?= yii\helpers\Url::to(['/product-make/index']) ?>">View...</a>  
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href='<?= yii\helpers\Url::to(['/product-model/index']) ?>'>
            <div class="card card-stats">
                <div class="card-header" data-background-color="red">
                    <i class="material-icons">clear</i>
                </div>
                <div class="card-content">
                    <p class="category">Product Models</p>
                    <h3 class="title"><?= ProductModel::getCount() ?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">remove_red_eye</i> 
                        <a href="<?= yii\helpers\Url::to(['/product-model/index']) ?>">View...</a>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<?php
return;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-6">

            <label>
                PROPERTY VALUATION AND TAXATION TRENDS AS PER <?= Settings::getActiveYear() == 0 ? ' ALL TIME' : Settings::getActiveYear() ?>
            </label>
        </div>
        <div class="col-sm-6">
            <label class="btn btn-info btn-sm pull-right" id="chart_switch"><i class="material-icons">swap_horizon</i>Switch Charts</label>
        </div>

    </div>
</div>
<!--Graphs-->  
<div class="row">
    <div style="display: none" id="chart_1" class="col-sm-12">
        <?=
        \dosamigos\chartjs\ChartJs::widget([
            'type' => 'line',
            'options' => [
                'height' => '60%',
            ],
            'data' => [
                'labels' => [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'Augost',
                    'September',
                    'November',
                    'December'
                ],
                'datasets' => [
                    [
                        'lineTension' => 0,
                        'label' => 'Taxed',
                        'backgroundColor' => '#FFF176',
                    //'borderColor' => '#FFF176',
                    // 'data' => \app\models\property\Property::getChartData()['tax']
                    ],
                    [
                        'lineTension' => 0,
                        'label' => 'Valuated',
                        'backgroundColor' => '#81C784',
                    //'borderColor' => '#81C784',
                    //  'data' => \app\models\property\Property::getChartData()['val']
                    ],
                    [
                        'lineTension' => 0,
                        'label' => 'Registered',
                        'backgroundColor' => '#81D4FA',
                    //'borderColor' => '#81D4FA',
                    //  'data' => \app\models\property\Property::getChartData()['reg']
                    ],
                ]
            ]
        ])
        ?>
    </div>
    <div style="display: block" id="chart_2">
        <?=
        \dosamigos\chartjs\ChartJs::widget([
            'type' => 'bar',
            'options' => [
                'height' => '60%',
            ],
            'data' => [
                'labels' => [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'Augost',
                    'September',
                    'November',
                    'December'
                ],
                'datasets' => [
                    [
                        'label' => 'Taxed',
                        'backgroundColor' => '#FFF176',
                    //   'data' => \app\models\property\Property::getChartData()['tax']
                    ],
                    [
                        'label' => 'Valuated',
                        'backgroundColor' => '#81C784',
                    //   'data' => \app\models\property\Property::getChartData()['val']
                    ],
                    [
                        'label' => 'Registered',
                        'backgroundColor' => '#81D4FA',
                    //   'data' => \app\models\property\Property::getChartData()['reg']
                    ],
                ]
            ]
        ])
        ?>
    </div>
</div>

<script>

    $('#chart_switch').click(function () {
        if ($('#chart_1').css('display') === 'none') {
            $('#chart_1').css('display', 'block');
            $('#chart_2').css('display', 'none');
        } else {
            $('#chart_2').css('display', 'block');
            $('#chart_1').css('display', 'none');

        }
    });

</script>
