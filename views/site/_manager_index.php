<?php
$this->title = 'INVENTORY MANAGER DASHBOARD';
$this->params['breadcrumbs'][] = $this->title;
?>

<!--Slider Design Starts Here!-->
<h1 style="text-align: center; margin-top: -90px">System Setup</h1>

<div class="slider">
    <!-- product make -->
    <div class="slides col-lg-3 col-md-6 col-sm-6">
        <a href="<?= yii\helpers\Url::to(['/product-make/index']) ?>">
            <div class="card card-stats rectangle">
                <div class="card-header" data-background-color="blue">
                    <i class="glyphicon glyphicon-random"></i>
                </div>
                <div class="card-content box">
                    <p class="category">Product Makes</p>
                    <h3 class="title"><?= app\models\ProductMake::getCount() ?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <a href="<?= yii\helpers\Url::to(['/product-make/index']) ?>">View...</a>  
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!--Product model -->
    <div class="slides col-lg-3 col-md-6 col-sm-6">
        <a href='<?= yii\helpers\Url::to(['/product-model/index']) ?>'>
            <div class="card card-stats rectangle">
                <div class="card-header" data-background-color="green">
                    <i class="glyphicon glyphicon-hourglass"></i>
                </div>
                <div class="card-content box">
                    <p class="category">Product Models</p>
                    <h3 class="title"><?= app\models\ProductModel::getCount() ?></h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="glyphicon glyphicon-eye-open"></i> 
                        <a href="<?= yii\helpers\Url::to(['/product-model/index']) ?>">View...</a>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Product category -->
    <div class="slides col-lg-3 col-md-6 col-sm-6">
        <a href="<?= yii\helpers\Url::to(['/product-category/index']) ?>">
            <div class="card card-stats rectangle">
                <div class="card-header" data-background-color="">
                    <i class="glyphicon glyphicon-cog"></i>
                </div>
                <div class="card-content box">
                    <p class="category">Product Categories</p>

                    <h3 class="title"><?= app\models\ProductCategory::getCount() ?></h3>

                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="glyphicon glyphicon-eye-open"></i> 
                        <a href="<?= yii\helpers\Url::to(['/product-category/index']) ?>">View...</a>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Product supplier -->
    <div class="slides col-lg-3 col-md-6 col-sm-6">
        <a href="<?= yii\helpers\Url::to(['/supplier/index']) ?>">
            <div class="card card-stats rectangle">
                <div class="card-header" data-background-color="blue">
                    <i class="glyphicon glyphicon-home"></i>
                </div>
                <div class="card-content box">
                    <p class="category">Product supplier</p>
                    <h3 class="title">
                        <?= app\models\Supplier::getCount() ?>
                    </h3>
                </div>

                <div class="card-footer">
                    <div class="stats">
                        <i class="glyphicon glyphicon-eye-open"></i> 
                        <a href="<?= yii\helpers\Url::to(['/supplier/index']) ?>">View...</a>
                    </div>
                </div>
            </div>
        </a>

    </div>


    <!-- Product -->
    <div class="slides col-lg-3 col-md-6 col-sm-6">
        <a href="<?= yii\helpers\Url::to(['/product/index']) ?>">
            <div class="card card-stats rectangle">
                <div class="card-header" data-background-color="">
                    <i class="glyphicon glyphicon-baby-formula"></i>
                </div>
                <div class="card-content box">
                    <p class="category">Products</p>
                    <h3 class="title">
                        <?= app\models\Product::getProductCount() ?>
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="glyphicon glyphicon-plus-sign"></i>
                        <a href="<?= yii\helpers\Url::to(['/product/create']) ?>">Register new Product...</a>

                    </div>
                </div>
            </div>
        </a>
    </div>

    <button class="btn btn1" onclick="plusIndex(-1)">&#10094;</button>
    <button class="btn btn2" onclick="plusIndex(1)">&#10095;</button>
</div>

<script>
    var index = 1;

    function plusIndex(n) {
        index = index + n;
        showDashboard(index);
    }

    showDashboard(1);
    function showDashboard(n) {
        var i;
        var x = document.getElementsByClassName("slides");
        if (n > x.length) {
            index = 1
        }
        ;
        if (n < 1) {
            index = x.length
        }
        ;
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        x[index - 1].style.display = "block";
    }

//    autoSlide();
//    function autoSlide() {
//        var i;
//        var x = document.getElementsByClassName("slides");
//        for (i = 0; i < x.length; i++) {
//            x[i].style.display = "none";
//        }
//
//        if (index > x.length) {
//            index = 1
//        }
//        x[index - 1].style.display = "block";
//        index++;
//        setTimeout(autoSlide, 2000);
//    }
</script>

























































