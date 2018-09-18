<?php

##Check type of user currently looged in and display Dashboard as per user's role
##That is, System Administrator, Property Valuer, Property Valuer Incharge or TRA Office
#
#
###Get Current User Instance
$user = \app\models\User::findOne(Yii::$app->user->id);
###Check If User is System Administrator
if ($user->isAdmin()):
    echo $this->render('_admin_index', ['user' => $user]);
endif;
#
#
###Check If User is Property Valuer
if ($user->isValuer()):
    echo $this->render('_manager_index', ['user' => $user]);
endif;
#
#
###Check If User is Property Valuer Incharge
if ($user->isValuerIncharge()):
    echo $this->render('_valuer_incharge_index', ['user' => $user]);
endif;
#
#
###Check If User is TRA Officer
if ($user->isTraOfficer()):
    echo $this->render('_tra_officer_index', ['user' => $user]);
endif;
  



