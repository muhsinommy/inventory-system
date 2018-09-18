<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model_user, 'current_password')->passwordInput() ?>
    <?= $form->field($model_user, 'new_password')->passwordInput() ?> 
    <?= $form->field($model_user, 'confirm_password')->passwordInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'btn_save']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

