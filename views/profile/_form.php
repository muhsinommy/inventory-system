<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php
    $form = ActiveForm::begin([
                'enableAjaxValidation' => true
    ]);
    ?>

    <?php //$form->field($model, 'user_id')->textInput()  ?>

    <div class="row">
        <div class="col-sm-6">
            <?=
            $form->field($model, 'fname')->textInput([
                'maxlength' => true,
                'disabled' => $model->disableField(),
                'title' => 'Can not edit this field'
            ])
            ?>
        </div>
        <div class="col-sm-6">
            <?=
            $form->field($model, 'mname')->textInput([
                'maxlength' => true,
                'title' => 'Update your Middle name'
            ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?=
            $form->field($model, 'lname')->textInput([
                'maxlength' => true,
                'disabled' => $model->disableField(),
                'title' => 'This field can not be edited'
            ])
            ?>
        </div>
        <div class="col-sm-6">
            <?=
            $form->field($model, 'phone')->textInput([
                'maxlength' => true,
                'disabled' => $model->disableField(),
                'title' => 'This field can not be edited'
            ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?=
            $form->field($model, 'email')->textInput([
                'maxlength' => true
            ])
            ?>
        </div>
        <div class="col-sm-6">
            <?=
            $form->field($model, 'update_password')->textInput([
                'maxlength' => true,
                'type' => 'button',
                'class' => 'btn btn-info btn-block',
                'value' => 'Update Password',
                'id' => 'to_password_update'
            ])
            ?>

            <?php
//            $form->field($model_user, 'password')->passwordInput([
//                'maxlength' => true,
//                'placeholder' => 'Leave blank to retain original'])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?=
            $form->field($model_user, 'new_password')->passwordInput([
                'maxlength' => true,
                'placeholder' => 'Enter new Password',
                'style' => 'display: none',
                'id' => 'new_password'
            ])
            ?>

        </div>
        <div class="col-sm-6">
            <?=
            $form->field($model_user, 'password_confirm')->passwordInput([
                'maxlength' => true,
                'placeholder' => 'Repeat the password',
                'style' => 'display: none',
            ])
            ?>
        </div>
    </div>

    <?php //$form->field($model, 'profile_picture')->textInput(['maxlength' => true])           ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'btn_save']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    //Hide label for Password confirmation field
    $('label[for = "new_password"]').css('display', 'none');
    $('label[for = "user-password_confirm"]').css('display', 'none');
    /*Password Validation*/
    $('#user-password').keyup(function () {
        //User tries to change password, Display Password
        //Confirmation Field
        var password = $(this).val();
        var password_conf = $('#user-password_confirm').val();
        //Prevent Sequence of spaces
        $(this).val(password.trim(this));
        if (password.trim(this) !== '') {
            $('#new_password').css('display', 'block');
            $('label[for = "new_password"]').css('display', 'block');
            $('#user-password_confirm').css('display', 'block');
            $('label[for = "user-password_confirm"]').css('display', 'block');
        } else {
            //Keep Password Confirmation field Hidden!
            $('#new_password').val(null);
            $('#user-password_confirm').val(null);
            $('#new_password').css('display', 'none');
            $('#user-password_confirm').css('display', 'none');
            $('label[for = "new_password"]').css('display', 'none');
            $('label[for = "user-password_confirm"]').css('display', 'none');
            return;
        }

    });

    $('#password-confirm').keyup(function () {
        var password = $('#user-password').val();
        var password_conf = $(this).val();
        if (password === password_conf) {
            displayMatch();
            $('#btn_save').removeAttr('disabled');
        } else {
            displayMismatch();
            $('#btn_save').attr('disabled', 'disabled');
        }
    });



    function alertWeak() {
        var password_strength = $('#password-strength');
        password_strength.css('display', 'block');
        password_strength.html('Weak Password');
        password_strength.css('background-color', 'red');
    }

    function alertFair() {
        var password_strength = $('#password-strength');
        password_strength.css('display', 'block');
        password_strength.html('Fair Password');
        password_strength.css('background-color', 'orange');
    }

    function alertStrong() {
        var password_strength = $('#password-strength');
        password_strength.css('display', 'block');
        password_strength.html('Strong Password');
        password_strength.css('background-color', 'green');
    }

    function isWeak(password) {
        return !(isFair(password) || isStrong(password));
    }

    function isFair(password) {
        var status = false;
        //Check for uppercase
        if (password.math('[A-Z]') > 1)
            status = true;
        //Check for Digit
        else if (password.match('[0-9]') > 1)
            status = true;
        return status;
    }

    function displayMatch() {
        var password_strength = $('#password-strength');
        password_strength.css('display', 'block');
        password_strength.html('Passwords have Matched');
        password_strength.css('background-color', 'green');
    }

    function displayMismatch() {
        var password_strength = $('#password-strength');
        password_strength.css('display', 'block');
        password_strength.html('Passwords do not Match');
        password_strength.css('background-color', 'red');
    }

    $('#to_password_update').click(function () {
        var url = "<?= yii\helpers\Url::to(['/user/update-password', 'id' => $model->user_id]) ?>";
        window.location.href = url;

    });
</script>
