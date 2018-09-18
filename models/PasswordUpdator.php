<?php

namespace app\models;

use Yii;
use yii\base\Model;
use kartik\password\StrengthValidator;

/**
 * ContactForm is the model behind the contact form.
 */
class PasswordUpdator extends Model {

    public $curr_pass;
    public $curr_checker;
    public $new_pass;
    public $conf_pass;
    public $username;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['curr_pass', 'new_pass', 'conf_pass'], 'required'],
            [['new_pass','conf_pass'], StrengthValidator::className(), 'preset'=>'normal','userAttribute'=>'username'],
            //[['new_pass','conf_pass'],'string','length' => [6,100]],
            //[['new_pass','conf_pass'],'match','pattern' => '/[^a-zA-Z\d]/'],
            //[['curr_pass'], 'comparePass', 'message' => 'Did not match the current Password'],
            ['conf_pass', 'compare', 'compareAttribute' => 'new_pass'],
            [['curr_pass', 'new_pass', 'conf_pass'], 'trim'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'curr_pass' => 'Current Password',
            'new_pass' => 'New Password',
            'conf_pass' => 'Confirm Password'
        ];
    }

 
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $valid = \Yii::$app->getSecurity()->validatePassword($this->curr_pass, $this->curr_checker);
            if (!$valid):
                $this->addError('curr_pass', 'Did not match current password');
            endif;
            
            $invalid = \Yii::$app->getSecurity()->validatePassword($this->new_pass, $this->curr_checker);
            if ($invalid):
                  $this->addError('new_pass', 'Current and New Password should not match');
            endif;
            return true;
        }
        return false;
    }

}
