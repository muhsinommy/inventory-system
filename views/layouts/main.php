
<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\sidenav\SideNav;
use yii\helpers\Url;
use app\models\Profile;
use app\models\Supplier;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>

<?php
$user = app\models\User::findOne(Yii::$app->user->id);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title ><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link href="css/dashboard.css" rel="stylesheet">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    </head>
    <body>

        <?php $this->beginBody() ?>
        <!DOCTYPE html>


    <script src="js/ie-emulation-modes-warning.js"></script>
    <script src="js/jquery.js"></script>

    <nav class="navbar my-navbar navbar-fixed-top">
        <div class="container-fluid"  style="background-color: #436b95">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--<?php //echo Html::img("img/header.png")            ?>--> 
                <a class="navbar-brand" href="<?php echo Yii::$app->homeUrl; ?>" style="color:white">Vehicle Parts Inventory Management System  </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">

                    <!--                    <li><a href="#">My Profile</a></li>-->
                    <li><a href=" <?= Url::to(['/site/help']) ?>" style="color:white">Help</a></li>
                    <?php
                    if (Yii::$app->user->isGuest) {
                        echo '<li><a href="' . Url::to(['/site/login']) . '" style="color:white">Login</a></li>';
                    } else {
                        echo '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                                'Logout (' . Yii::$app->user->identity->user_name . ')', ['class' => 'btn btn-link logout', 'style' => 'color:white; margin-top: 10px']
                        )
                        . Html::endForm()
                        . '</li>';
                    }
                    ?>
                </ul>

            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar" id="side-nav-div-id">
                <ul class="nav nav-sidebar">
                    <?php
                    if (Yii::$app->user->isGuest) {

                        echo SideNav::widget([
                            'type' => SideNav::TYPE_DEFAULT,
                            'items' => [

                                ['label' => 'Home', 'icon' => 'home', 'url' => Url::to(['/site/index']), 'active' => (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'home')],
                            // ['label' => 'Selected Students', 'icon' => ' glyphicon glyphicon-education', 'url' => Url::to(['/registration/reg-selected-student/']), 'active' => ($this->context->id == 'reg-selected-student'),
                            //],
                            ],
                        ]);
                    } else {

                        echo SideNav::widget([
                            'type' => SideNav::TYPE_DEFAULT,
                            'heading' => '<center><img src="' . Profile::getProfilePicture() . '" class="img img-circle" style="width: 100px; height: 100px; margin-left:auto; margin-right: auto"/></center>',
                            'items' => [
                                [
                                    'label' => 'Home',
                                    'icon' => 'home',
                                    'url' => Yii::$app->homeUrl
                                ],
                                [
                                    'label' => 'My Profile',
                                    'icon' => 'user',
                                    'url' => ['profile/update', 'id' => Yii::$app->user->id]
                                ],
                                [
                                    'label' => 'Users',
                                    'icon' => 'user',
                                    'url' => ['user/index'],
                                    'visible' => $user->isAdmin()
                                ],
                                [
                                    'label' => 'User Roles',
                                    'icon' => 'user',
                                    'url' => ['role/index'],
                                    'visible' => $user->isAdmin()
                                ],
                                [
                                    'label' => 'Product Suppliers [ ' . Supplier::getCount() . ' ]',
                                    'icon' => 'user',
                                    'url' => ['supplier/index'],
                                    'visible' => $user->isManager()
                                ],
                            ]
                        ]);
                    }
                    ?>




                </ul>

            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <br>
                <?php
                echo Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
                ?>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 pull-right">
                        <!--Check for a success flash message-->
                        <?php if (Yii::$app->getSession()->hasFlash('message_updated')): ?>
                            <div class="flash alert alert-success alert-dismissable col-md-6 pre_load" id="flash">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button" id="btn_close" title="Close">X</button>
                                <i class="glyphicon glyphicon-ok"></i>
                                <?= Yii::$app->getSession()->getFlash('message_updated') ?>
                            </div>
                        <?php endif; ?>

                        <!--Check for a warning flash message-->
                        <?php if (Yii::$app->getSession()->hasFlash('message_warning')): ?>
                            <div class="flash alert alert-warning alert-dismissable col-md-6 pre_load" id="flash">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button" id="btn_close" title="Close">X</button>
                                <i class="glyphicon glyphicon-ok"></i>
                                <?= Yii::$app->getSession()->getFlash('message_warning') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <h1 class="page-header" style="font-size: 1.7em" id="page-header-id"><?= $this->title ?></h1>
                <?= $content ?>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script>

    jQuery(document).ready(function () {
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ')
                    c = c.substring(1);
                if (c.indexOf(name) == 0)
                    return c.substring(name.length, c.length);
            }
            return "";
        }

        jQuery("a").on('click', function (e) {
            e.preventDefault();
            var nav_bar_position = $("#side-nav-div-id").scrollTop();
            setCookie("nav_bar_position", nav_bar_position, 1);
            document.cookie = "nav_bar_position=" + nav_bar_position;
            var url = jQuery(this).attr('href');
            document.location.href = url;

        });

        var stored_nav_position = getCookie("nav_bar_position");
        $("#side-nav-div-id").scrollTop(stored_nav_position);
    });

    //For closing Flash Message box
    $('#btn_close').click(function () {
        //Hide Successfully Update Message!
        $('#flash').css('display', 'none');
    });
</script>
