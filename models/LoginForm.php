<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model {

    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;
    public $submit;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            //Update the last_login field in table user
            date_default_timezone_set('Africa/Dar_es_Salaam');
            $this->getUser()->last_login = date('Y-m-d H:i:s');
            $this->getUser()->save();
            //Add new Record to table Login
            $login = new Login();
            $login->user_id = $this->getUser()->getId();
            $login->ip_address = Login::getIPAddress();
            $login->browser = Login::getBrowserInfo();
            $login->location = Login::getLoginLocation();
            $login->save();

            //Check if user is still using default password
            if (\Yii::$app->getSecurity()->validatePassword(User::DEFAULT_PASSWORD, $this->getUser()->password)) {
                $message = 'Your password is default, You need to' . \yii\helpers\Html::a(' Update It!', ['/user/update-password', 'id' => $this->getUser()->user_id]);
                \Yii::$app->getSession()->setFlash('message_warning', $message);
            } else {
                //Welcome Message
                $message = "Welcome, " . Profile::findOne($this->getUser()->getId())->getFullName()
                        . ' (' . Role::findOne($this->getUser()->role)->role_desc . ')';
                //Attach Welcoming Message to session
                Yii::$app->getSession()->setFlash('message_updated', $message);
            }

            //Store timestamp for Inactivity Checking
            Yii::$app->getSession()->set('login_timestamp', time());


            //Login the User
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        if ($this->getUser() !== null) {
            $issue = new \app\models\Issue();
            $issue->user_id = $this->getUser()->user_id;
            $issue->action = '/site/login';
            $issue->viewed = \app\models\Issue::NOT_VIEWED;
            $issue->description = \app\models\Issue::ERROR_LOGIN_FAILURE;
            $issue->save();
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    public function attributeLabels() {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'submit' => ''
        ];
    }

}
