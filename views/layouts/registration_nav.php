<?php

//

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\sidenav\SideNav;
use yii\helpers\Url;
use app\models\Users;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


echo SideNav::widget([
    'type' => SideNav::TYPE_DEFAULT,
    //'encodeLabels' => false,
    //'heading' => 'Navigation',vw-students-current-year
    'items' => [
            ['label' => 'Home', 'icon' => 'home', 'url' => Url::to(['/site/index']), 'active' => (Yii::$app->controller->id == 'site')],
             ['label' => ' My Profile', 'icon' => 'user', 'url' => Url::to(['/users/profile']), 'active' => (Yii::$app->controller->id == 'users'),
               ],
                // ----------------> Link for fresh students <------------------
//        ['label' => 'Registration Form', 'icon' => 'glyphicon glyphicon-file', 'url' => Url::to(['/registration/registration-form/student-registration-form']), 'active' => (( Yii::$app->controller->id) == 'registration-form'),
//            'visible' => yii::$app->user->identity->user_type == 3,
//        ],
        ['label' => 'Medical Form', 'icon' => 'glyphicon glyphicon-file', 'url' => Url::to(['/registration/medical-form/download-medical-form']), 'active' => ( (Yii::$app->controller->id) == 'medical-form'),
            'visible' => yii::$app->user->identity->user_type == 3,
        ],
        ['label' => 'Attachments', 'icon' => 'glyphicon glyphicon-upload', 'url' => Url::to(['/registration/academic-certificates/upload-certificates']), 'active' => ( (Yii::$app->controller->id) == 'academic-certificates'),
            'visible' => yii::$app->user->identity->user_type == 3,
        ],
        ['label' => 'Admission Letter', 'icon' => 'glyphicon glyphicon-duplicate', 'url' => Url::to(['/registration/admission-letter/student-admission-letter']), 'active' => (( Yii::$app->controller->id) == 'admission-letter'),
            'visible' => yii::$app->user->identity->user_type == 3,
        ],
     
        ['label' => 'Verification',
            'icon' => 'glyphicon glyphicon-play-circle',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/registration/continuing-students-verification/index') && yii::$app->user->can('/registration/fresh-students-verification/index'),
            'items' => [

                ['label' => 'Continuing Students', 'url' => ['/registration/continuing-students-verification'], 'active' => (( Yii::$app->controller->id) == 'continuing-students-verification'),
                ],
                ['label' => 'Fresh Students', 'url' => ['/registration/fresh-students-verification'], 'active' => (( Yii::$app->controller->id) == 'fresh-students-verification'),
                ],
//                        ['label' => 'New Selected', 'url' => ['/vw-freshers-requirement/index'], 'active' => (( Yii::$app->controller->id) == 'vw-freshers-requirement'),
//                    ]
            ],
        ],
        ['label' => 'Loan Allocations',
            'icon' => 'glyphicon glyphicon-stats',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/registration/continuing-students-allocation/index') && yii::$app->user->can('/registration/fresh-students-allocation/index'),
            'items' => [

                ['label' => 'Continuing Students', 'url' => ['/registration/continuing-students-allocation'], 'active' => (( Yii::$app->controller->id) == 'continuing-students-allocation'),
                ],
                ['label' => 'Fresh Students', 'url' => ['/registration/fresh-students-allocation'], 'active' => (( Yii::$app->controller->id) == 'fresh-students-allocation'),
                ],
//                        ['label' => 'New Selected', 'url' => ['/vw-freshers-requirement/index'], 'active' => (( Yii::$app->controller->id) == 'vw-freshers-requirement'),
//                    ]
            ],
        ],
        ['label' => 'Upload Fresh Students', 'icon' => 'glyphicon glyphicon-upload', 'url' => Url::to(['/registration/upload-selected-student']), 'active' => (( Yii::$app->controller->id) == 'upload-selected-student'),
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/registration/upload-selected-student/index'),
        ],
        ['label' => 'Fee Structure', 'icon' => 'glyphicon glyphicon-equalizer', 'url' => Url::to(['/registration/fee-structure']), 'active' => (( Yii::$app->controller->id) == 'fee-structure'),
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/registration/fee-structure/index'),
        ],
        ['label' => 'Open|Close Registration', 'icon' => 'glyphicon glyphicon-off', 'url' => Url::to(['/registration/reg-registration']), 'active' => (( Yii::$app->controller->id) == 'reg-registration'),
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/registration/reg-registration/index'),
        ],
        ['label' => 'Admission Letter', 'icon' => 'glyphicon glyphicon-duplicate', 'url' => Url::to(['/registration/admission-letter']), 'active' => (( Yii::$app->controller->id) == 'admission-letter'),
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/registration/admission-letter/index'),
        ],
        
        ['label' => 'Password Reset',
            'icon' => 'glyphicon glyphicon-off',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/registration/fresh-students-password-reset/index'),
            'items' => [
                ['label' => 'Fresh Students', 'url' => ['/registration/fresh-students-password-reset'], 'active' => (( Yii::$app->controller->id) == 'fresh-students-password-reset'),
                ],
//                        ['label' => 'New Selected', 'url' => ['/vw-freshers-requirement/index'], 'active' => (( Yii::$app->controller->id) == 'vw-freshers-requirement'),
//                    ]
            ],
        ],
        
        ['label' => 'Configurations',
            'icon' => 'cog',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/registration/set-registration-requirement/set-requirement'),
            'items' => [

                ['label' => 'Registration Requirement', 'url' => Url::to(['/registration/set-registration-requirement']), 'active' => ((yii::$app->controller->id) == 'set-registration-requirement'),
                ],
            ]],
        ['label' => 'Requirement Config',
            'icon' => 'wrench',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/registration/set-registration-requirement-per-programme/index') && yii::$app->user->can('/registration/set-registration-requirement-intakewise/index'),
            'items' => [
                ['label' => 'Per Programme', 'url' => Url::to(['/registration/set-registration-requirement-per-programme']), 'active' => ((yii::$app->controller->id) == 'set-registration-requirement-per-programme'),
                ],
                ['label' => 'Per Intake', 'url' => Url::to(['/registration/set-registration-requirement-intakewise']), 'active' => ((yii::$app->controller->id) == 'set-registration-requirement-intakewise'),
                ],
            ]],
        ['label' => 'Registration Setup',
            'icon' => 'compressed',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/registration/reg-requirement-set/index') && yii::$app->user->can('/registration/reg-requirement-item/index') && yii::$app->user->can('/registration/reg-payment-type/index'),
            'items' => [
                ['label' => 'Requirement Set', 'url' => Url::to(['/registration/reg-requirement-set']), 'active' => (($this->context->id) == 'reg-requirement-set'),
                ],
                ['label' => 'Registration Requirements', 'url' => Url::to(['/registration/reg-requirement-item']), 'active' => (($this->context->id) == 'reg-requirement-item'),
                ],
                ['label' => 'Requirement Type', 'url' => Url::to(['/registration/reg-requirement-type']), 'active' => (($this->context->id) == 'reg-requirement-type'),
                ],
                ['label' => 'Payment Types', 'url' => Url::to(['/registration/reg-payment-type']), 'active' => (($this->context->id) == 'reg-payment-type'),
                ],
               
            ]],
        ['label' => 'Logout', 'icon' => 'off', 'url' => Url::to(['/site/logout'])],
    ],
]);











