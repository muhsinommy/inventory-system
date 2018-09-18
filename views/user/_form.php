<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <label style="font-size: .9em"><i>Fields with <font color="red">*</font> are mandatory!</i></label><hr>
    <br>
    <?=
    yii\bootstrap\Progress::widget([
        'percent' => 100,
        'barOptions' => ['class' => 'progress-bar-success'],
        'options' => ['class' => 'active progress-striped col-md-6 pre_load',
            //'style' => 'display: none',
            'style' => 'margin-top: 70px; display: none',
            'id' => 'progress_bar_creating user'],
        'label' => 'Updating user details, please wait ...'
    ]);
    ?>

    <?php
    $form = ActiveForm::begin([
                'id' => 'user-registration-form',
                'enableAjaxValidation' => true
            ])
    ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model_profile, 'fname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model_profile, 'mname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model_profile, 'lname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model_profile, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model_profile, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'role')->dropDownList(app\models\Role::getRoles(), ['prompt' => 'Select User Role']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'is_active')->dropDownList(app\models\User::getActiveStatuses(), ['prompt' => null]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'user_name')->dropDownList($model->getUserNameOptions(), ['prompt' => null]) ?>
        </div>
    </div>

    <?php //$form->field($model, 'user_name')->textInput(['maxlength' => true])   ?>

    <?php //$form->field($model, 'password')->passwordInput(['maxlength' => true])   ?>

    <?php //$form->field($model, 'password_hash')->textInput(['maxlength' => true])    ?>



    <?php //$form->field($model, 'access_token')->textInput(['maxlength' => true])   ?>

    <?php //$form->field($model, 'auth_key')->textInput(['maxlength' => true])   ?>

    <?php //$form->field($model, 'last_login')->textInput()    ?>

    <div class="form-group">
        <?=
        Html::submitButton('Save', [
            'class' => 'btn btn-success',
            'id' => 'btn_save'
        ])
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $('.btn').click(function () {
        $('#progress_bar_creating user').css('display', 'block');
    });

    $('#region').change(function () {
        var url = "<?= yii\helpers\Url::to(['/profile/get-districts']) ?>&id=" + $(this).val();
        $.ajax({
            url: url,
            success: function (data) {
                $('#district').html(data);
            }
        });
    });
    $('#region').click(function () {
        $(this).change();
    });
    //Ensure everything is in CAPITAL LETTER EXCEPT EMAIL
      $('input[type = "text"]').keyup(function () {
        if ($(this).attr('id') !== 'profile-email') {
            $(this).val($(this).val().toUpperCase());
        }
    });
    
    //0652755770

</script>