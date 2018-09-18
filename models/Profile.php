<?php

namespace app\models;

use Yii;
use app\models\validators\NameValidator;

/**
 * This is the model class for table "profile".
 *
 * @property int $user_id
 * @property string $fname
 * @property string $mname
 * @property string $lname
 * @property string $phone
 * @property string $email
 * @property string $profile_picture
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord {
    
     public $update_password;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['fname', 'lname', 'phone', 'email'], 'required'],
            ['phone', \miserenkov\validators\PhoneValidator::className(), 'country' => 'TZ'],
            [['email'], 'email', 'message' => 'Email address is invalid!'],
            [['email'], 'unique', 'message' => 'Email address is in use!'],
            [['phone'], 'unique', 'message' => 'Phone number is in use!'],
            [['fname', 'mname', 'lname', 'email', 'profile_picture'], 'string', 'max' => 128],
            [['phone'], 'string', 'max' => 16],
            [['fname', 'mname', 'lname', 'profile_picture', 'email'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            ['fname', NameValidator::className()],
            ['mname', NameValidator::className()],
            ['lname', NameValidator::className()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => 'User ID',
            'fname' => 'First name',
            'mname' => 'Middle name',
            'lname' => 'Last name',
            'phone' => 'Phone Number',
            'email' => 'Email Address',
            'profile_picture' => 'Profile Picture',
            'update_password' => ''
        ];
    }

    /* /**
     * @return \yii\db\ActiveQuery
     */

    public function getUser() {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    public function getLoggedUser() {
        return User::findOne($this->user_id);
    }

    //Returns Full name of the Current Logged in User
    public static function getUserFullName() {
        $profile = self::findOne(Yii::$app->user->id);
        $full_name = $profile->fname . ' ' . $profile->lname;
        return $full_name;
    }

    //Returns User profile picture
    public static function getProfilePicture() {
        $profile_picture = "images/ic_user_default.png";
        $profile = self::findOne(Yii::$app->user->id);
        if ($profile->profile_picture != null)
            $profile_picture = $profile->profile_picture;
        return $profile_picture;
    }

    //Disables spefic form field
    public function disableField() {
        return $this->user_id !== null;
    }

    //Returns full name of a specic user
    public function getFullName() {
        $fullname = $this->fname . ' ' . $this->lname;
        return $fullname;
    }

  

}
