<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ProductCategory;
use app\models\config\Status;
use app\models\Supplier;
use app\models\ProductMake;
use app\models\ProductModel;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($details, 'make')->dropDownList(ProductMake::getMakes(), ['id' => 'product_make','prompt' => 'Select Product Make...']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($details, 'model')->dropDownList([ProductModel::getModels()[$details->model]], ['id' => 'product_model','prompt'=> 'Select Product Model...']) ?>

        </div>
        <div class="col-sm-4">
            <?php //$form->field($details, 'type')->dropDownList(ProductCategory::getCategories(), []) ?>
        </div>
    </div>

    <hr>
    <label>Other Details</label>
    <hr>

    <div class="row">

        <div class="col-sm-4">
            <?= $form->field($model, 'category')->dropDownList(ProductCategory::getCategories(), []) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'details')->textInput() ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'status')->dropDownList(Status::getStatuses(), []) ?>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-4">
            <?= $form->field($model, 'supplier')->dropDownList(Supplier::getSuppliers(), []) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'is_purchased')->dropDownList(Status::getShipmentStatus(), []) ?>
        </div>
        <div class="col-sm-4">
            <?php //$form->field($model, 'price')->textInput() ?>

            <?=
            $form->field($model, 'price')->widget(kartik\money\MaskMoney::className(), [
                'pluginOptions' => [
                    'prefix' => 'TSHS ',
                    'allowNegative' => false,
                    'allowZero' => false,
                ],
                'options' => [
                    'placeholder' => 'Product Price',
                    'autofocus' => true
                ]
            ])
            ?>
        </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>

    $('#product_make').change(function () {

        var url = "<?= yii\helpers\Url::to(['product/details']) ?>&make_id=" + $(this).val();

        $.ajax({
            url: url,
            success: function (data) {
                $('#product_model').html(data);
            }
        });
    });

</script>
