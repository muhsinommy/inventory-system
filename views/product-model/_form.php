<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ProductMake;

/* @var $this yii\web\View */
/* @var $model app\models\ProductModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'make')->dropDownList(ProductMake::getMakes(), []) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'model_desc')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
