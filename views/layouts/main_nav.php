<?php

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
//        ['label' => 'Registration', 'icon' => 'glyphicon glyphicon-scale', 'url' => Url::to(['/student-registration/index']), 'active' => (( Yii::$app->controller->id) == 'student-registration'),
//            'visible' => yii::$app->user->identity->user_type == 1 || yii::$app->user->identity->user_type == 3,
//        ],
//         ['label' => 'Registration Form', 'icon' => 'glyphicon glyphicon-file', 'url' => Url::to(['/student-registration/registration-form']), 'active' => (( Yii::$app->controller->id) == 'student-registration'  && ( Yii::$app->controller->action->id) == 'registration-form'),
//            'visible' => (yii::$app->user->identity->user_type == 1 && yii::$app->user->identity->is_registered == 1) || (yii::$app->user->identity->user_type == 3 && yii::$app->user->identity->is_registered == 1),
//        ],
        ['label' => \app\models\InstitutionBasedTerminology::find()->where(" terminology_key = 'UE'")->one()->terminology_name . ' Results', 'icon' => ' glyphicon glyphicon-list', 'url' => Url::to(['/student-year-of-study/index']), 'active' => (( Yii::$app->controller->id) == 'student-year-of-study'),
            'visible' => yii::$app->user->identity->user_type == 1 && yii::$app->user->identity->is_registered == 1,
        ],
        ['label' => 'CA Results', 'icon' => 'glyphicon glyphicon-paperclip', 'url' => Url::to(['/course-works/index']), 'active' => (( Yii::$app->controller->id) == 'course-works'),
            'visible' => yii::$app->user->identity->user_type == 1 && yii::$app->user->identity->is_registered == 1,
        ],
        // ----------------> Link for fresh students <------------------
//        ['label' => 'Registration Form', 'icon' => 'glyphicon glyphicon-file', 'url' => Url::to(['/registration/registration-form/student-registration-form']), 'active' => (( Yii::$app->controller->id) == 'registration-form'),
//            'visible' => yii::$app->user->identity->user_type == 3,
//        ],
        ['label' => 'Medical Form', 'icon' => 'glyphicon glyphicon-file', 'url' => Url::to(['/registration/medical-form/download-medical-form']), 'active' => ( (Yii::$app->controller->id) == 'medical-form'),
            'visible' => yii::$app->user->identity->user_type == 3,
        ],
        ['label' => 'Academic Certificates', 'icon' => 'glyphicon glyphicon-upload', 'url' => Url::to(['/registration/academic-certificates/upload-certificates']), 'active' => ( (Yii::$app->controller->id) == 'academic-certificates'),
            'visible' => yii::$app->user->identity->user_type == 3,
        ],
        ['label' => 'Admission Letter', 'icon' => 'glyphicon glyphicon-duplicate', 'url' => Url::to(['/registration/admission-letter/student-admission-letter']), 'active' => (( Yii::$app->controller->id) == 'admission-letter'),
            'visible' => yii::$app->user->identity->user_type == 3,
        ],
        //-------------------------->End<-----------------------------------
        // ................link for registered students...........................
//        ['label' => ' Course Registration', 'icon' => 'glyphicon glyphicon-th-large', 'url' => Url::to(['/register-courses/index']), 'active' => (Yii::$app->controller->id == 'register-courses'),
//            'visible' => yii::$app->user->identity->user_type == 1 && yii::$app->user->identity->is_registered == 1,
//        ],
//        ['label' => 'Course Material', 'url' => Url::to(['/student-course-material/index']), 'active' => (Yii::$app->controller->id == "student-course-material" || Yii::$app->controller->id == "index"), 'icon' => 'glyphicon glyphicon-book',
//            'visible' => yii::$app->user->identity->user_type == 1 && yii::$app->user->identity->is_registered == 1,
//        ],
//        ['label' => 'Timetable', 'url' => Url::to(['/student-course-timetable/index']), 'active' => (Yii::$app->controller->id == "student-course-timetable" || Yii::$app->controller->id == "index"), 'icon' => 'glyphicon glyphicon-time',
//            'visible' => yii::$app->user->identity->user_type == 1 && yii::$app->user->identity->is_registered == 1,
//        ],
        ['label' => 'Grading System', 'url' => Url::to(['/grading-system-versions/student-grading-system']), 'active' => (Yii::$app->controller->id == "grading-system-versions"), 'icon' => 'list-alt',
            'visible' => yii::$app->user->identity->user_type == 1 && yii::$app->user->identity->is_registered == 1,
        ],
        ['label' => 'Classification of Award', 'url' => Url::to(['/classification-of-awards/index']), 'active' => (Yii::$app->controller->id == "classification-of-awards"), 'icon' => 'education',
            'visible' => yii::$app->user->identity->user_type == 1 && yii::$app->user->identity->is_registered == 1,
        ],
        //................................End of student links ..................................
        ['label' => 'Manage Students', 'icon' => 'education', 'url' => Url::to(['/vw-students/index']), 'active' => (Yii::$app->controller->id == 'vw-students' || Yii::$app->controller->id == 'students'),
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/vw-students/index'),
        ],
        ['label' => 'Student Accounts', 'icon' => 'barcode', 'url' => Url::to(['/students-manager/index']), 'active' => ((yii::$app->controller->id) == 'students-manager'),
            'visible' => yii::$app->user->identity->user_type == 2 && Yii::$app->user->can('/students-manager/index'),
        ],
//                                ['label' => 'Process Results', 'url' => Url::to(['/process-results/index']), 'active' => (Yii::$app->controller->id == "process-results" ), 'icon' => 'glyphicon glyphicon-refresh',
//                                    'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/process-results/index'),
//                                ],
        ['label' => 'Approve|Publish', 'url' => Url::to(['/approve-publish-results/index']), 'active' => (Yii::$app->controller->id == "approve-publish-results" ), 'icon' => 'glyphicon glyphicon-align-justify',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/approve-publish-results/index'),
        ],
//        ['label' => 'Course Results', 'url' => Url::to(['/vw-offered-courses/index']), 'active' => ((Yii::$app->controller->id == "vw-offered-courses") || (Yii::$app->controller->id == "vw-course-results")), 'icon' => 'list-alt',
//            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/vw-offered-courses/index'),
//        ],
        ['label' => \app\models\InstitutionBasedTerminology::find()->where(" terminology_key = 'course'")->one()->terminology_name . ' Results - CA', 'url' => Url::to(['/course-work-management/index']), 'active' => ((Yii::$app->controller->id == "course-work-management")), 'icon' => 'bullhorn',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/course-work-management/index'),
        ],
        ['label' => \app\models\InstitutionBasedTerminology::find()->where(" terminology_key = 'course'")->one()->terminology_name . ' Results - ' . \app\models\InstitutionBasedTerminology::find()->where(" terminology_key = 'UE'")->one()->terminology_name, 'url' => Url::to(['/course-results/index']), 'active' => ((Yii::$app->controller->id == "course-results")), 'icon' => 'stats',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/course-results/index'),
        ],
        ['label' => 'Transcripts|Statements', 'url' => Url::to(['/vw-students-current-year/index']), 'active' => (Yii::$app->controller->id == "vw-students-current-year" || Yii::$app->controller->id == "reports"), 'icon' => 'share-alt',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/vw-students-current-year/index'),
        ],
        ['label' => 'Reports',
            'icon' => 'duplicate',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/general-reports/index'),
            'items' => [
                ['label' => 'Academic Reports', 'url' => Url::to(['/general-reports/index']), 'active' => (Yii::$app->controller->id == "general-reports" ),
                    'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/general-reports/index'),
                ],
                ['label' => 'Performance Bar Chart', 'url' => Url::to(['/performance-bar-chart/index']), 'active' => (yii::$app->controller->id == 'performance-bar-chart'),
                    'visible' => Yii::$app->user->can('/performance-bar-chart/index'),
                ],
                ['label' => 'Summary Reports',
                    'icon' => '',
                    'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/enrolled-students-summary/index'),
                    'items' => [

                        ['label' => 'Examination Results', 'url' => Url::to(['/examination-summary/index']), 'active' => (yii::$app->controller->id == 'examination-summary'),
                            'visible' => Yii::$app->user->can('/examination-summary/index'),
                        ],
                        ['label' => 'Enrolled Students', 'url' => Url::to(['/enrolled-students-summary/index']), 'active' => (yii::$app->controller->id == 'enrolled-students-summary'),
                            'visible' => Yii::$app->user->can('/enrolled-students-summary/index'),
                        ],
//                        ['label' => 'Default Configuration', 'url' => Url::to(['/configure-programme-year-oneforall/index']), 'active' => (($this->context->id) == 'configure-programme-year-oneforall'),
//                        ],
                    ]],
            ]],
        ['label' => \app\models\InstitutionBasedTerminology::find()->where(" terminology_key = 'course'")->one()->terminology_name . ' Material', 'url' => Url::to(['/course-material/index']), 'active' => (Yii::$app->controller->id == "course-material" || Yii::$app->controller->id == "index"), 'icon' => 'glyphicon glyphicon-paperclip',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/course-material/index'),
        ],
//        ['label' => 'Assign Teaching Staff', 'url' => Url::to(['/assign-staff-course/index']), 'active' => (Yii::$app->controller->id == "assign-staff-course"), 'icon' => 'glyphicon glyphicon-share',
//            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/assign-staff-course/index'),
//        ],
        ['label' => 'Assign ' . \app\models\InstitutionBasedTerminology::find()->where(" terminology_key = 'course'")->one()->terminology_name . ' T/Staff', 'url' => Url::to(['/assigned-staff-course/index']), 'active' => (Yii::$app->controller->id == "assigned-staff-course"), 'icon' => 'glyphicon glyphicon-share',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/assigned-staff-course/index'),
        ],
        ['label' => 'Examination Number', 'url' => Url::to(['/exam-number-version/index']), 'active' => (Yii::$app->controller->id == "exam-number-version" || Yii::$app->controller->id == "exam-number"), 'icon' => 'glyphicon glyphicon-eject',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('Administrator'),
        ],
        ['label' => 'Audit Trail', 'url' => Url::to(['/user-audit-trail/index']), 'active' => (Yii::$app->controller->id == "user-audit-trail" || Yii::$app->controller->id == "index"), 'icon' => 'glyphicon glyphicon-info-sign',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('Administrator'),
        ],
        ['label' => 'System Modules',
            'icon' => 'th-large',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/registration/*'),
            'items' => [

                ['label' => 'Registration', 'url' => Url::to(['/registration']), 'active' => ((yii::$app->controller->id) == 'course-offering-versions'),
                    'visible' => Yii::$app->user->can('/registration/*'),
                ],
            ]],
        ['label' => 'Configurations',
            'icon' => 'cog',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/study-years/index'),
            'items' => [

                ['label' => 'Course Offering', 'url' => Url::to(['/course-offering-versions/index']), 'active' => ((yii::$app->controller->id) == 'course-offering-versions'),
                    'visible' => Yii::$app->user->can('/course-offering-versions/index'),
                ],
                ['label' => 'Grading System', 'url' => Url::to(['/grading-system-versions/index']), 'active' => ((yii::$app->controller->id) == 'grading-system-versions'),
                    'visible' => Yii::$app->user->can('/grading-system-versions/index'),
                ],
//                ['label' => 'Programme Years', 'url' => Url::to(['/study-years/index']), 'active' => (yii::$app->controller->id == 'study-years'),
//                    'visible' => Yii::$app->user->can('/study-years/index'),
//                ],
                ['label' => 'Programme Years',
                    'icon' => '',
                    'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/study-years/index'),
                    'items' => [

                        ['label' => 'General Configuration', 'url' => Url::to(['/study-years/index']), 'active' => (yii::$app->controller->id == 'study-years'),
                            'visible' => Yii::$app->user->can('/study-years/index'),
                        ],
//                        ['label' => 'Default Configuration', 'url' => Url::to(['/configure-programme-year-oneforall/index']), 'active' => (($this->context->id) == 'configure-programme-year-oneforall'),
//                        ],
                    ]],
            ]],
        ['label' => 'Student Payments',
            'icon' => '',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('/enrolled-students-summary/index'),
            'items' => [

                ['label' => 'Post Student Bill', 'url' => Url::to(['/payment/post-student-bill']), 'active' => ((yii::$app->controller->id == 'payment') && (yii::$app->controller->action->id == 'post-student-bill')),
                //'visible' => Yii::$app->user->can('/examination-summary/index'),
                ],
                  ['label' => 'Student Bill', 'url' => Url::to(['/payment-posted-student-bill/index']), 'active' => ((yii::$app->controller->id == 'payment-posted-student-bill') && (yii::$app->controller->action->id == 'index')),
                //'visible' => Yii::$app->user->can('/examination-summary/index'),
                ],
                ['label' => 'Votebook-Student', 'url' => Url::to(['/payment/post-registered-student']), 'active' => ((yii::$app->controller->id == 'payment') && (yii::$app->controller->action->id == 'post-registered-student') ),
                //'visible' => Yii::$app->user->can('/enrolled-students-summary/index'),
                ],
//                ['label' => 'Get Student Transaction', 'url' => Url::to(['/payment/get-student-transaction']), 'active' => ((yii::$app->controller->id == 'payment') && (yii::$app->controller->action->id == 'get-student-transaction')),
//                //'visible' => Yii::$app->user->can('/enrolled-students-summary/index'),
//                ],
                ['label' => 'Student Transaction', 'url' => Url::to(['/payment-student-transaction/index']), 'active' => ((yii::$app->controller->id == 'payment-student-transaction') && (yii::$app->controller->action->id == 'index')),
                //'visible' => Yii::$app->user->can('/enrolled-students-summary/index'),
                ],
            ]],
        ['label' => 'System Setup',
            'icon' => 'compressed',
            'visible' => yii::$app->user->identity->user_type == 2 && yii::$app->user->can('Administrator'),
            'items' => [
//                                         ['label' => 'Study Years', 'url' => Url::to(['/study-year-classification/index']), 'active' => (( Yii::$app->controller->id) == 'study-year-classification'),
//                                           'visible' => Yii::$app->user->can('/study-year-classification/index'),
//                                        ],
//                                           ['label' => 'Classrooms', 'url' => Url::to(['/classrooms/index']), 'active' => (( Yii::$app->controller->id) == 'classrooms'),
//                                            'visible' => Yii::$app->user->can('/classrooms/index'),
//                                        ],
                ['label' => 'Move Year', 'url' => Url::to(['/move-academic-year/index']), 'active' => (( Yii::$app->controller->id) == 'move-academic-year'),
                    'visible' => Yii::$app->user->can('/move-academic-year/index'),
                ],
                ['label' => 'Institution Terminology', 'url' => Url::to(['/institution-based-terminology/index']), 'active' => (( Yii::$app->controller->id) == 'institution-based-terminology'),
                    'visible' => Yii::$app->user->can('/institution-based-terminology/index'),
                ],
                ['label' => 'Report Templates', 'url' => Url::to(['/report-templates/index']), 'active' => (( Yii::$app->controller->id) == 'report-templates'),
                    'visible' => Yii::$app->user->can('/report-templates/index'),
                ],
                ['label' => 'Institution Types', 'url' => Url::to(['/institution-type/index']), 'active' => (( Yii::$app->controller->id) == 'institution-type'),
                    'visible' => Yii::$app->user->can('/institution-type/index'),
                ],
                ['label' => 'Institution Structure', 'url' => Url::to(['/institution-structure/index']), 'active' => (( Yii::$app->controller->id) == 'institution-structure'),
                    'visible' => Yii::$app->user->can('/institution-structure/index'),
                ],
                ['label' => 'Programme Types', 'url' => Url::to(['/programme-type/index']), 'active' => (( Yii::$app->controller->id) == 'programme-type'),
                    'visible' => Yii::$app->user->can('/programme-type/index'),
                ],
                ['label' => 'Programmes', 'url' => Url::to(['/programmes/index']), 'active' => (( Yii::$app->controller->id) == 'programmes'),
                    'visible' => Yii::$app->user->can('/programmes/index'),
                ],
                ['label' => \app\models\InstitutionBasedTerminology::find()->where(" terminology_key = 'course'")->one()->terminology_name, 'url' => Url::to(['/courses/index']), 'active' => (( Yii::$app->controller->id) == 'courses'),
                    'visible' => Yii::$app->user->can('/courses/index'),
                ],
                ['label' => 'Sessions', 'url' => Url::to(['/sessions/index']), 'active' => (( Yii::$app->controller->id) == 'sessions'),
                    'visible' => Yii::$app->user->can('/sessions/index'),
                ],
                ['label' => 'Intakes', 'url' => Url::to(['/intakes/index']), 'active' => (( Yii::$app->controller->id) == 'intakes'),
                    'visible' => Yii::$app->user->can('/intakes/index'),
                ],
                ['label' => 'Academic Years',
                    'url' => Url::to(['/academic-years/index']), 'active' => (( Yii::$app->controller->id) == 'academic-years'),
                    'visible' => Yii::$app->user->can('/academic-years/index'),
                ],
                //['label' => 'Approval Statuses', 'url' => Url::to(['/approval-status/index']), 'active' => (( Yii::$app->controller->id) == 'approval-status'),],
                ['label' => 'Staff Positions', 'url' => Url::to(['/staff-positions/index']), 'active' => (( Yii::$app->controller->id) == 'staff-positions'),
                    'visible' => Yii::$app->user->can('/staff-positions/index'),
                ],
                ['label' => 'Examination Number Format', 'url' => Url::to(['/exam-number-format/index']), 'active' => (( Yii::$app->controller->id) == 'exam-number-format'),
                    'visible' => Yii::$app->user->can('/exam-number-format/index'),
                ],
//                                        ['label' => 'Student Statuses', 'url' => Url::to(['/student-status/index']), 'active' => (( Yii::$app->controller->id) == 'student-status'),
//                                            'visible' => Yii::$app->user->can('/student-status/index'),
//                                        ],
//                                        // ['label' => 'Student Year Statuses', 'url' => Url::to(['/student-year-status/index']), 'active' => (( Yii::$app->controller->id) == 'student-year-status'),],
//                                        ['label' => 'Student Year Status', 'url' => Url::to(['/student-year-status/index']), 'active' => (( Yii::$app->controller->id) == 'student-year-status'),
//                                            'visible' => Yii::$app->user->can('/student-year-status/index'),
//                                        ],
//                                        ['label' => 'Semester Statuses', 'url' => Url::to(['/student-semester-status/index']), 'active' => (( Yii::$app->controller->id) == 'student-semester-status'),
//                                            'visible' => Yii::$app->user->can('/student-semester-status/index'),
//                                        ],
//                                        ['label' => 'Pgm Year Statuses', 'url' => Url::to(['/programme-year-status/index']), 'active' => (( Yii::$app->controller->id) == 'programme-year-status'),
//                                            'visible' => Yii::$app->user->can('/programme-year-status/index'),
//                                        ],
//                                        ['label' => 'Course Statuses', 'url' => Url::to(['/student-course-status/index']), 'active' => (( Yii::$app->controller->id) == 'student-course-status'),
//                                            'visible' => Yii::$app->user->can('/student-course-status/index'),
//                                        ],
            ]],
        ['label' => 'User Management',
            'icon' => 'cog',
            'visible' => yii::$app->user->identity->user_type == 2 && (yii::$app->user->can('Administrator') || yii::$app->user->can('Level-Administrator')),
            'items' => [
                // ['label' => 'User Levels', 'url' => Url::to(['/user-levels/index']),'active' => ((yii::$app->controller->id) == 'user-levels')],

                ['label' => 'Staff', 'url' => Url::to(['/staff-manager/index']), 'active' => ((yii::$app->controller->id) == 'staff-manager' || ( yii::$app->controller->id == 'user-levels')),
                    'visible' => Yii::$app->user->can('/staff-manager/index'),
                ],
                ['label' => 'Login History', 'url' => Url::to(['/logins/index']), 'active' => (yii::$app->controller->id == 'logins'),
                    'visible' => Yii::$app->user->can('/logins/index'),
                ],
            //['label' => 'Audit Trail', 'url' => Url::to(['/user-audit-trail/index']), 'active' => (yii::$app->controller->id == 'user-audit-trail')],
            //['label' => 'Results Upload History', 'url' => Url::to(['/results-upload-history/index']), 'active' => (yii::$app->controller->id == 'results-upload-history')],
            //['label' => 'Login Attempts', 'url' => Url::to(['/login-attempts/index']), 'active' => (yii::$app->controller->id == 'login-attempts')],
//                ['label' => 'Roles', 'url' => Url::to(['/admin/role']), 'active' => ((yii::$app->controller->id) == 'role'),
//                    'visible' => Yii::$app->user->can('/admin/role/*'),
//                ],
//                                        ['label' => 'Permission', 'url' => Url::to(['/admin/permission']), 'active' => ((yii::$app->controller->id) == 'permission'),
//                                            'visible' => Yii::$app->user->can('/admin/permission/*'),
//                                        ],
//                                        ['label' => 'Routes', 'url' => Url::to(['/admin/route']), 'active' => ((yii::$app->controller->id) == 'route' ),
//                                            'visible' => Yii::$app->user->can('/admin/route/*'),
//                                        ],
            ]],
        ['label' => 'Logout', 'icon' => 'off', 'url' => Url::to(['/site/logout'])],
    ],
]);





