<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

 
<div class="site-login">
    <h1>
<?php /* ?> <?= Html::encode($this->title) ?><?php */ ?>
    </h1>
    <div class="row">
        <div class="col-sm-3"><center><img src="images/car_parts.jpg" alt="Responsive image" width="200" height="200" class="img img-circle img-responsive" align="middle" style="margin-top: 50px"/></center><br>
            <small><center>

                </center></small></div>
        <div  class="col-sm-6">
            <p>Please fill out the following fields to login:</p>
<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <div style="color:#999;margin:1em 0"> 
                If you forgot your password you can
<?= Html::a('reset it', ['site/reset']) ?>
                 </div>
            <div class="form-group">
<?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
                <?php ActiveForm::end(); ?>
        </div>

<?php if (Yii::$app->session->hasFlash('flashMessage')): ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                <h5><i class="icon fa fa-check"></i>Confirmation Sent!</h5>
    <?= \Yii::$app->session->getFlash('flashMessage'); ?>
            </div>
            <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('successMessage')): ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                <h5><i class="icon fa fa-check"></i>Password Successfully changed!</h5>
    <?= \Yii::$app->session->getFlash('successMessage'); ?>
            </div>
            <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('deactivatedMessage')): ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                <h5><i class="icon fa fa-check"></i>Error!</h5>
    <?= \Yii::$app->session->getFlash('deactivatedMessage'); ?>
            </div>
            <?php endif; ?>
    </div>
</div>



