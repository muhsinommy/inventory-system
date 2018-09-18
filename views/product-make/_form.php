<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\config\Country;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model app\models\ProductMake */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-make-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'make_desc')->textInput() ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'country')->dropDownList(Country::getCountries(), []) ?>
        </div>
        <div class="col-sm-4">
            <label id="btn_update_make_logo" class="btn btn-info btn-block" style="margin-top: 25px">Upload Make Logo</label>
            <?php //$form->label('Upload Make Logo', ['class' => 'btn btn-info', 'id' => 'btn_update_make_logo']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!--Dialog Window that shows Product Make Logo Upload Options-->
<?php
Modal::begin([
    'header' => 'Update Make Logo',
    'id' => 'modal_make_logo_update',
    'size' => Modal::SIZE_LARGE
]);
?>
<div id="content_id" style="width: 100%">

    <label class="control-label">Attach Logo</label>
    <?=
    kartik\file\FileInput::widget([
        'name' => 'product_logo',
        'options' => [
            'multiple' => false,
            'accept' => 'image/*'
        ],
        'pluginOptions' => [
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i>',
            'showUpload' => true,
            'browseLabel' => 'Attach picture',
            'browseClass' => 'btn btn-success btn-block',
            'showCaption' => true,
            'autoOrientImage' => true,
            //'frameClass' => 'pull-center',
            'uploadUrl' => yii\helpers\Url::to(['/product-make/upload-logo', 'id' => $model->make_id]),
            'showCancel' => true,
            'layoutTemplates' => 'main2'
        ],
    ])
    ?>

</div>
<?php
Modal::end();
?>
<!--End Dialog Window-->

<script>
    $('#btn_update_make_logo').click(function () {
        $('#modal_make_logo_update').modal('show');
        // .find('#content_id')
        //  .load($(this).attr('value'));
    });
    //    $('.img').css('width', '100px');
    //    $('.img').css('height', '100px');
    $('#profile_picture').css('height', '120px');
    $('#profile_picture').css('width', '120px');

</script>
