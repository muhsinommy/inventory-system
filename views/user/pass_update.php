<?php

use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;

$this->title = 'UPDATE USER PASSWORD';
$this->params['breadcrumbs'][] = ['label' => 'MY PROFILE', 'url' => ['/profile/update', 'id' => $id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$form = ActiveForm::begin()
?>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'curr_pass')->passwordInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-6">
        <?=
        $form->field($model, 'new_pass')->widget(PasswordInput::classname(), [
            'pluginOptions' => [
                'showMeter' => true,
                'toggleMask' => false
            ]
        ]);
        ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?=
        $form->field($model, 'conf_pass')->widget(PasswordInput::classname(), [
            'pluginOptions' => [
                'showMeter' => true,
                'toggleMask' => false
            ]
        ]);
        ?>
    </div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-5">
                <label class="btn btn-info" id="generate_pass" onclick="generatePass()">Generate Password</label>
            </div>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="gen_pass"/>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'btn_save']) ?>
</div>

<?php
ActiveForm::end();
?>

<script>
   

    function generatePass() {
        var pass = "<?= Yii::$app->getSecurity()->generateRandomString(10) ?>";
        $('#gen_pass').val(pass);
    }
</script>