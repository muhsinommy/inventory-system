<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "login".
 *
 * @property int $login_id
 * @property int $user_id
 * @property string $ip_address
 * @property string $browser
 * @property string $location
 * @property string $time_stamp
 *
 * @property User $user
 */
class Login extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'login';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'ip_address', 'browser'], 'required'],
            [['user_id'], 'integer'],
            [['time_stamp'], 'safe'],
            [['ip_address'], 'string', 'max' => 15],
            [['browser', 'location'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'login_id' => 'Login ID',
            'user_id' => 'User ID',
            'ip_address' => 'Ip Address',
            'browser' => 'Browser',
            'location' => 'Location',
            'time_stamp' => 'Time Stamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    //Returns IP Address of the Machine Used
    public static function getIPAddress() {
        return getenv('HTTP_CLIENT_IP') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR');
    }

    //Returns Browser Details of the Machine Used
    public static function getBrowserInfo() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    //Returns Location where user was, when Logged in
    public static function getLoginLocation() {
        $location_api = "http://api.ipinfodb.com/v3/ip-city/?key=" . self::getIPAddress();
        $contents = json_decode($location_api . "&format=json");
        //return $contents->regionName.'-'.$contents->countryName;
        return null;
    }

}
