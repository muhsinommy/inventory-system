<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\bootstrap\Progress;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'USER ROLES';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <div style="">



        <?=
        Progress::widget([
            'percent' => 100,
            'barOptions' => ['class' => 'progress-bar-success'],
            'options' => ['class' => 'active progress-striped col-md-6 pre_load',
                'style' => 'display: none',
                'id' => 'progress_bar'],
            'label' => 'Saving Changes, please wait ...'
        ]);
        ?>
        <?=
        Progress::widget([
            'percent' => 100,
            'barOptions' => ['class' => 'progress-bar-success'],
            'options' => ['class' => 'active progress-striped col-md-6 pre_load',
                'style' => 'display: none',
                'id' => 'progress_bar_for_loading_routes'],
            'label' => 'Loading routes, please wait ...'
        ]);
        ?>
    </div>
    <div class="row">
        <div class="col-md-4">
            <p>
                <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
        </div>
        <div class="col-md-4">
            <p>
                <?= Html::a('Reload Granted Accesses', ['/main/reload-granted-access'], ['class' => 'btn btn-success btn-sm hidden']) ?>
            </p>
        </div>
        <div class="col-md-4">
            <p class="pull-right">
                <?= Html::a('Reload Actions', ['/main/save-new-routes'], ['class' => 'btn btn-success btn-sm', 'id' => 'btn_reload_actions']) ?>
            </p>
        </div>
    </div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'role_id',
            //'role_code',
            'role_desc',
            [
                'label' => 'Permission',
                'value' => function ($model) {
                    return Html::a('Manage', '#', [
                                'class' => 'label label-success',
                                'onclick' => 'openDialog(' . $model->role_id . ')'
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


<!--Dialog Window for Assigning permissions to the roles-->
<?php
Modal::begin([
    'header' => 'Grant Permissions to Roles',
    'id' => 'modal_permission_grant',
    'size' => Modal::SIZE_LARGE
]);
?>
<div id="content_id" style="width: 100%">

    <table class="table table-hover table-bordered table-striped table-condensed">
        <caption id="table_caption"></caption>
        <tr>
            <th>
                SNO
            </th>
            <th>
                Route
            </th>
            <th>
                <?= \yii\helpers\Html::checkbox('check_all', false, ['id' => 'check_all', 'value' => 0]) ?>
                <sup>Select all</sup>
            </th>
        </tr>
        <?php $sn = 1; ?>
        <?php foreach (\app\models\Action::find()->all() as $key => $route): ?>
            <tr>
                <td>
                    <?= $sn++ ?>
                </td>
                <td>
                    <?= $route['route'] ?>
                </td>
                <td>
                    <?= \yii\helpers\Html::checkbox('box_' . ($sn - 1), false, ['id' => 'box_' . ($sn - 1), 'value' => $route['action_id']]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php $row_count = ($sn - 1); ?>
    </table>
    <?= Html::a('Save', '#', ['class' => 'btn btn-success btn-sm', 'id' => 'btn_save_permissions']) ?>
</div>
<?php
Modal::end();
?>
<!--JavaScript Codes-->
<script>

    //Display progress bar when 'Reload Actions' Button
    //Is Clicked
    $('#btn_reload_actions').click(function () {
        $('#progress_bar_for_loading_routes').css('display', 'block');
    });


    //Opens Dialog Window @param id, is the role id
    function openDialog(id) {
        //Set value for the check_all checkbox be the role id
        $('#check_all').val(id);
        //Create a url that returns the description of the role @param id is parameter
        var role_desc_url = "<?= \yii\helpers\Url::to(['get-role-desc']) ?>&id=" + id;
        //Create variable role_desc, that stores value for role description
        var role_desc = null;
        //Start Ajax call
        $.ajax({url: role_desc_url, //Created url
            success: function (data) {//Call passed, data is value for role_desc
                //Assign data to role_desc
                role_desc = data;
                //Set html contents of table caption, include role_desc
                $('#table_caption').html("<strong>Actions performed by " + role_desc + "</strong>");
                //End Ajax call
            }});
        //Set values for other check boxes
        var str_actions = '';//Stores sequence of action ids separated by ','
        //Iterate from 1 in row_count times
        for (var i = 1; i <= parseInt("<?= $row_count ?>"); i++) {
            //Read value of the i th checkbox
            var action = $('#box_' + i).val();
            //Append the value to the sequence
            str_actions = str_actions + action + ',';
        }
        //Create a url that gives information about checked statuses from database
        var check_url = "<?= \yii\helpers\Url::to(['/main/find-permission']) ?>&role=" + id + "&str_actions=" + str_actions;
        //Start Ajax Call
        $.ajax({
            url: check_url, //Use check_url
            success: function (data) {
                //Create an Array from sequnce of checked values returned
                var response = data.split(',');
                //Remove last element of an array as it is ','
                response.pop();
                //Iterate from 1 in row_count times
                for (var i = 1; i <= parseInt("<?= $row_count ?>"); i++) {
                    //Check if checked value for (i-1)th checkbox is checked
                    if (response[i - 1] == 'checked')
                        //Make the (i-1)th box checked
                        $('#box_' + i).prop('checked', 'checked');
                    else
                        //Otherwise mark it unchecked
                        $('#box_' + i).prop('checked', null);
                }

            }
            //End Ajax Call
        });
        //Open the Dilog Window
        $('#modal_permission_grant').modal('show');
    }
    //End openDialog()

    //Check if dom contents are fully loaded
    $(document).ready(function () {
        /**Working with Dialog Options**/
        $('#check_all').change(function () {
            //Check if main checkbox is checked
            if ($(this).is(':checked')) {
                //Mark all checkboxes checked
                for (var i = 1; i <= parseInt("<?= $row_count ?>"); i++) {
                    $('#box_' + i).prop('checked', 'checked');
                }
            } else {
                //Mark all checkboxes unchecked
                for (var i = 1; i <= parseInt("<?= $row_count ?>"); i++) {
                    $('#box_' + i).prop('checked', null);
                }
            }
        });
    });

    //Saving selections
    $('#btn_save_permissions').click(function () {
        //Read role_id
        var role_id = $('#check_all').val();
        //String for unchecked action ids sequence
        var str_unchecked = '';
        //String for checked action ids sequence
        var str_checked = '';
        //Iterate through all checkboxes
        for (var i = 1; i <= parseInt("<?= $row_count ?>"); i++) {
            //Check if box is checked
            if ($('#box_' + i).is(':checked')) {
                //Read action id f
                var action = $('#box_' + i).val();
                //Append the action id to str_unchecked
                str_checked = str_checked + action + ',';
            } else {
                //Read action id
                var action = $('#box_' + i).val();
                //Append action id to str_unchecked
                str_unchecked = str_unchecked + action + ',';
            }
        }
        //Create url to execute update process
        var url = "<?= \yii\helpers\Url::to(['/main/save-permissions']) ?>&role=" + role_id + "&str_checked=" + str_checked + "&str_unchecked=" + str_unchecked;
        //Make a call to url
        window.location.href = url;
        //Open progress dialog
        $('#progress_bar').css('display', 'block');
        $('#modal_permission_grant').modal('hide');
    });
</script>


<?php
Modal::begin([
    'header' => null,
    'id' => 'progress_bar',
    'size' => Modal::SIZE_DEFAULT
]);
?>


<?php Modal::end() ?>

