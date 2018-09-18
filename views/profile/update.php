<?php

use yii\helpers\Html;
use yii\jui\Dialog;
use yii\bootstrap\Modal;
use yii\helpers\Json;

//
///* @var $this yii\web\View */
///* @var $model app\models\Profile */
//
$this->title = 'UPDATE PROFILE FOR: ' . app\models\Profile::getUserFullName();
//$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="profile-update">


</div>

<div class="row">
    <div class="col-md-4">
        <div class="card card-profile">
            <div class="card-avatar">

                <img class="img img-container"  src="<?= app\models\Profile::getProfilePicture() ?>" title="<?= app\models\Profile::getUserFullName() ?> " id="profile_picture"/>

            </div>
            <div class="content">
                <h4 class="card-title"><?= app\models\Profile::getUserFullName() ?></h4>
                <h5 class="category text-gray">(<?= $model->getLoggedUser()->getRoleName() ?>)</h5>

                <div class="row">
                    <div class="col-sm-6">
                        <a href="#" class="btn btn-success" id="btn_update_profile_picture" title="Update profile picture">
                            <i class="glyphicon glyphicon-pencil"></i>
                            <font style="font-size: 10px">Update Profile Picture</font>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?= yii\helpers\Url::to(['/profile/remove-profile-picture', 'id' => $model->user_id]) ?>" class="btn btn-danger" id="btn_remove_profile_picture" title="Remove profile picture">
                            <i class="glyphicon glyphicon-remove"></i>
                            <font style="font-size: 10px">Remove Profile Picture</font>
                        </a>
                    </div>
                </div>

            </div>     
        </div>
        <div class='row'>
            <table class="table table-bordered table-hover" style="margin-left: 10px; width: 94%">
                <tr>
                    <th>
                        <label class="label label-info">
                            Last login
                        </label>
                    </th>
                    <th>
                        <label class="label label-info">
                            <?= \app\tools\Tool::getFormattedTime(\app\models\User::findOne($model->user_id)->last_login)?>
                        </label>
                    </th>
                </tr>
                <tr>
                    <th>
                        <label class="label label-info">
                            Login Count
                        </label>
                    </th>
                    <th>
                        <label class="label label-info">
                            <?= \app\models\User::findOne($model->user_id)->getNumLogins()?>
                        </label>
                    </th>

                </tr>
                <tr style="display: none">
                    <th>
                        <label class="label label-warning">
                            Login Failures
                        </label>
                    </th>
                    <th>
                        <label class="label label-warning">
                            19
                        </label>
                    </th>
                </tr>
            </table>


            <center>
                <a href="<?= yii\helpers\Url::to(['/user/logout']) ?>">
                    <i class="material-icons">exit_to_app</i>
                    <p>Logout</p>
                </a>
            </center>


        </div>

    </div>



    <div class="col-md-8">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Edit your Profile</h4>
                <p class="category">Complete your profile</p>
            </div>
            <div class="card-content">
                <?=
                $this->render('_form', [
                    'model' => $model,
                    'model_user' => $model_user
                ])
                ?>
            </div>
        </div>
    </div>

</div>

<!--Dialog Window that shows Profile Picture Upload Options-->
<?php
Modal::begin([
    'header' => 'Update Profile Picture',
    'id' => 'modal_profile_picture_update',
    'size' => Modal::SIZE_LARGE
]);
?>
<div id="content_id" style="width: 100%">

    <label class="control-label">Attach picture</label>
    <?=
    kartik\file\FileInput::widget([
        'name' => 'user_icon',
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
            'uploadUrl' => yii\helpers\Url::to(['/profile/upload-profile-picture', 'id' => $model->user_id]),
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
    $('#btn_update_profile_picture').click(function () {
        $('#modal_profile_picture_update').modal('show');
        // .find('#content_id')
        //  .load($(this).attr('value'));
    });
    //    $('.img').css('width', '100px');
    //    $('.img').css('height', '100px');
    $('#profile_picture').css('height', '120px');
    $('#profile_picture').css('width', '120px');

</script>


