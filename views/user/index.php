<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'user_id',
            //'password',
            //'password_hash',
            //'role',
            [
                'label' => 'First name',
                'value' => function ($model) {
                    return app\models\Profile::findOne($model->user_id)->fname;
                }
            ],
            [
                'label' => 'Last name',
                'value' => function ($model) {
                    return app\models\Profile::findOne($model->user_id)->lname;
                }
            ],
            'user_name',
            [
                'attribute' => 'role',
                'value' => function ($model) {
                    return app\models\Role::findOne($model->role)->role_desc;
                },
                'filter' => \app\models\Role::getRoles()
            ],
            [
                'attribute' => 'is_active',
                'value' => function ($model) {
                    return $model->is_active ? '<label class="label label-success">Yes</label>' : '<label class="label label-danger">No</label>';
                },
                'format' => 'raw',
                'filter' => [
                    true => 'Yes',
                    false => 'No'
                ]
            ],
            //'access_token',
            //'auth_key',
            [
                'attribute' => 'last_login',
                'value' => function ($model) {
                    return $model->last_login == null ? 'Never' : $model->getFormattedTime();
                }
            ],
            [
                'label' => 'Login Count',
                'value' => function ($user) {
                    return $user->getNumLogins();
                }
            ],
            [
                'label' => null,
                'value' => function ($user) {
                    return Html::a('<i class="material-icons">lock_open</i>', ['/user/reset-password', 'id' => $user->user_id], [
                                'title' => 'Reset Password for ' . $user->getUserProfile()->getFullName()
                    ]);
                },
                        'format' => 'raw'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}'
                    ],
                ],
            ]);
            ?>
</div>
