<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IssueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Issues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class = "issue-index" >  <?php // echo $this->render('_search', ['model' => $searchModel]);         ?> <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//'issue_id',
            [
                'attribute' => 'user_id',
                'label' => 'User Full Name',
                'value' => function ($model) {
                    return app\models\Profile::findOne($model->user_id)->getFullName();
                },
                'filter' => \app\models\User::getUserFullNames()
            ],
            'action',
            [
                'attribute' => 'description',
                'filter' => \app\models\Issue::getFailures()
            ],
            [
                'attribute' => 'reported_at',
                'value' => function ($model) {
                    return app\tools\Tool::getFormattedTime($model->reported_at);
                }
            ],
//            [
//                'attribute' => 'viewed',
//                'label' => 'Seen',
//                'value' => function ($model) {
//                    
//                }
//            ],
            [
                'label' => null,
                'value' => function ($model) {
                    return Html::a('<label class="label label-danger"><i class="fa fa-close" title="Delete this Item"></i></label>', ['set-viewed', 'id' => $model->issue_id]);
                },
                        'format' => 'raw'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => null
                    ],
                ],
            ]);
            ?>  </div > 
