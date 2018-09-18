<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\validators;

use yii\validators\Validator;

class NameValidator extends Validator {

    public function validateAttribute($model, $attribute) {
        
        if ($model->$attribute != null && trim($model->$attribute) != ''):
            if (!ctype_alpha($model->$attribute)) {
            $this->addError($model, $attribute, "{attribute} has Invalid Characters");
        }
        endif;
    }

}
