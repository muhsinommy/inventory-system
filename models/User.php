<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $user_id
 * @property string $user_name
 * @property string $password
 * @property string $password_hash
 * @property int $role
 * @property string $access_token
 * @property string $auth_key
 * @property string $last_login
 *
 * @property Login[] $logins
 * @property Profile $profile
 * @property Property[] $properties
 * @property Property[] $properties0
 * @property Role $role0
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * For Changing User Password
     * * */
    public $current_password;
    public $new_password;
    public $confirm_password;
    public $password_confirm;

    /* Constants */

    const IS_ACTIVE_ON = 1; //For Active User Account
    const IS_ACTIVE_OFF = 0; //For Inactive User Account
    const DEFAULT_PASSWORD = '12345'; //For Default Password

    /**
     * @inheritdoc
     */

    public function rules() {
        return [
            [[/* 'user_name', */ 'password_hash', 'role', 'access_token', 'auth_key'], 'required'],
            // ['password', 'required', 'when' => $this->isNewRecord],
            [['role', 'is_active', 'registered_by', 'updated_by'], 'integer'],
            [['last_login', 'date_registered', 'date_updated'], 'safe'],
            [['user_name', 'password', 'password_hash', 'access_token', 'auth_key', 'password_confirm'], 'string', 'max' => 128],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role' => 'role_id']],
                //[['password_confirm'],'required','when' => true]
                //Validation based on changing user password
                //[['current_password', 'new_password', 'confirm_password'], 'required'],
                //[['current_password', 'new_password', 'confirm_password'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => 'User ID',
            'user_name' => 'Username',
            'password' => 'Current Password',
            'password_hash' => 'Password Hash',
            'role' => 'Role',
            'is_active' => 'Active',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
            'last_login' => 'Last Login',
            'date_registered' => 'Registration date',
            'date_updated' => 'Update date',
            'registered_by' => 'Registered by',
            'updated_by' => 'Updated_by',
            'new_password' => 'New Password',
            'password_confirm' => 'Confirm Password'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogins() {
        return $this->hasMany(Login::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile() {
        return $this->hasOne(Profile::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties() {
        return $this->hasMany(Property::className(), ['approved_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties0() {
        return $this->hasMany(Property::className(), ['registered_by' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole0() {
        return $this->hasOne(Role::className(), ['role_id' => 'role']);
    }

    //Returns Role name Of User Currently Logged in
    public function getRoleName() {
        if ($this !== null):
            $user = User::findOne(Yii::$app->user->id);
            $user_role = Role::findOne($user->role);
            return $user_role->role_desc;
        else:
            return '';
        endif;
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function getId() {
        return $this->user_id;
    }

    public function validateAuthKey($authKey) {
        return $authKey == $this->getAuthKey();
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return self::findOne(['access_token' => $token]);
    }

    public static function findByUsername($user_name) {

        if (self::isEmail($user_name))
            return self::findOne(['user_name' => $user_name]);
        else
            return self::findOne(['user_name' => self::getFormattedUserName($user_name)]);
    }

    public function validatePassword($password) {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    //Returns Total Number Of Users
    public static function getNumUsers() {
        return self::find()->count();
    }

    //Returns total number of active users
    public static function getNumActiveUsers() {
        return self::find()->where(['is_active' => 1])->count();
    }

    //Returns total number of inactive users
    public static function getNumInactiveUsers() {
        return self::find()->where(['is_active' => 0])->count();
    }

    //Returns total number of System administrators
    public static function getNumAdmins() {
        $role = Role::findOne(['role_code' => Role::SYSTEM_ADMIN]);
        return self::find()->where(['role' => $role->role_id])->count();
    }

    //Returns total number of Property Valuers
    public static function getNumPropertyValuers() {
        $role = Role::findOne(['role_code' => Role::PROPERTY_VALUER]);
        return self::find()->where(['role' => $role->role_id])->count();
    }

    //Returns total number of Property Valuers In Charge
    public static function getNumPropertyValuersInCharge() {
        $role = Role::findOne(['role_code' => Role::PROPERTY_VALUER_IN_CHARGE]);
        return self::find()->where(['role' => $role->role_id])->count();
    }

    //Returns total number of TRA Officers
    public static function getNumTraOfficers() {
        $role = Role::findOne(['role_code' => Role::TRA_OFFICER]);
        return self::find()->where(['role' => $role->role_id])->count();
    }

    //Returns array of Active Statuses indexed by Status value
    public static function getActiveStatuses() {
        return [
            self::IS_ACTIVE_OFF => 'No',
            self::IS_ACTIVE_ON => 'Yes',
        ];
    }

    //Returns Username options (Email Or Phone number)
    public function getUserNameOptions() {
        $profile = Profile::findOne($this->getId());
        //Will be Executed for an Existing Account
        if (!$profile->isNewRecord) {
            return [
                $profile->email => 'Email address',
                $profile->phone => 'Phone number'
            ];
        }
        //Will be Executed for a new Account
        return [
            'email' => 'Email address',
            'phone' => 'Phone number'
        ];
    }

    //Generates default password for a User account
    public function generateDefaultPassword() {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash(self::DEFAULT_PASSWORD);
        return $this->password_hash;
    }

    //Resets User Password
    public function resetPassword() {
        return $this->generateDefaultPassword();
    }

    //Checks If Username is Phone number
    public function isUserNamePhoneNumber() {
        $profile = Profile::findOne($this->getId());
        return $this->user_name === $profile->phone;
    }

    //Checks If Username is Email address
    public function isUserNameEmailAdd() {
        $profile = Profile::findOne($this->getId());
        return $this->user_name === $profile->email;
    }

    //Formarts phone number to International Standards
    public static function getFormattedUserName($phone_number) {
        //Checks if user_name is a valid phone number, if not a random string is returned as user_name
        if (!\miserenkov\validators\PhoneValidator::getPhoneUtil()->isViablePhoneNumber($phone_number)) {
            return Yii::$app->getSecurity()->generateRandomString();
        }
        //The phone number supplied is valid, formart it to suit international standard eg +255 765 890 987
        $phone = \miserenkov\validators\PhoneValidator::getPhoneUtil()->parse($phone_number, 'TZ');
        return \miserenkov\validators\PhoneValidator::getPhoneUtil()->format($phone, \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
    }

    /*     * *
     * Checks if the provided value is an email address 
     * @param string to be checked
     * * */

    public static function isEmail($param) {
        return filter_var($param, FILTER_VALIDATE_EMAIL);
    }

    public function getFormattedTime() {
        date_default_timezone_set('Africa/Dar_es_Salaam');
        $logged_time = str_replace(' ', '-', str_replace(':', '-', $this->last_login));
        $logged_time = explode('-', $logged_time);
        $day = $logged_time[2];
        $month = $logged_time[1];
        $year = $logged_time[0];

        $hour = $logged_time[3];
        $minute = $logged_time[4];
        $second = $logged_time[5];

        $time = $day . '/' . $month . '/' . $year . ', ' . $hour . ':' . $minute . ':' . $second;
        return $time;
    }

    //Returns number of Logins for a user
    public function getNumLogins() {
        $count = Login::find()->where([
                    'user_id' => $this->user_id
                ])->count();
        return number_format($count);
    }

    //Returns the Elapsed time since last login
    public function getTimeFromLogin() {
        date_default_timezone_set('Africa/Dar_es_Salaam');
        //Stores names of all possible times
        $times = ['Years', 'Months', 'Days', 'Hours', 'Minutes', 'Seconds'];
        $time = ['Year', 'Month', 'Day', 'Hour', 'Minute', 'Second'];
        //Get the current time stamp
        $now = explode('-', date('Y-m-d-h-i-s'));
        $logged_time = str_replace(' ', '-', str_replace(':', '-', $this->last_login));
        $logged_time = explode('-', $logged_time);
        for ($i = 0; $i < count($now); $i++) {
            $difference = $now[$i] - $logged_time[$i];
            if ($difference == 0) {
                continue;
            } else {
                if ($difference > 1)
                    $elapsed_time = $difference . ' ' . $times[$i] . ' ago';
                else
                    $elapsed_time = $difference . ' ' . $time[$i] . ' ago';
                break;
            }
        }

        return $elapsed_time;
    }

    //Returns user's role_code
    public function getRoleCode() {
        return Role::findOne($this->role)->role_code;
    }

    //Returns true if Current user is System Administrator
    public function isAdmin() {
        return $this->getRoleCode() == Role::SYSTEM_ADMIN;
    }

    //Returns true if current user is Inventory Manager
    public function isManager() {
        return $this->isValuer();
    }

    //Returns true if Current user is Property Valuer
    public function isValuer() {
        return $this->getRoleCode() == Role::PROPERTY_VALUER;
    }

    //Returns true if Current user is Property Valuer Incharge
    public function isValuerIncharge() {
        return $this->getRoleCode() == Role::PROPERTY_VALUER_IN_CHARGE;
    }

    //Returns true if Current user is TRA Officer
    public function isTraOfficer() {
        return $this->getRoleCode() == Role::TRA_OFFICER;
    }

    //Returns profile model of the User
    public function getUserProfile() {
        $profile = Profile::findOne($this->user_id);
        return $profile;
    }

    //Checks if User is Actis
    public function isActive() {
        return $this->is_active == 1;
    }

    //Assigns Role to the newly Created user, it also includes access
    //Granting.
    public function setGrantedAccess() {
        #Get all actions a user can perform as per assigned role
        $can_perform = CanPerform::find()->where(['role' => $this->role])->all();
        $count_assigned = 0;
        foreach ($can_perform as $key):
            $action = Action::findOne($key->action)->route;
            $assignment = new auth\AuthAssignment();
            $assignment->user_id = $this->user_id;
            $assignment->item_name = $action;
            $assignment->created_at = time();
            if ($assignment->save()):
                $count_assigned++;
            endif;
        endforeach;
        //Set Flash Message
    }

    //Updates Access to an existing user, whose role has changed
    public function updateGrantedAccess() {
        #Get all current access
        $curr_assignments = auth\AuthAssignment::find()->where(['user_id' => $this->user_id])->all();
        #Delete everything from $curr_assignments
        foreach ($curr_assignments as $curr_assignment):
            $curr_assignment->delete();
        endforeach;
        #Create new Assignments
        $this->setGrantedAccess();
    }

    //Returns List of Recently Registered Users
    public static function getRecentList() {
        
    }

    //Returns User Full names Indexed by user_id's
    public static function getUserFullNames() {
        $names = [];
        $userids = self::find()->select(['user_id'])->all();
        foreach ($userids as $userid) {
            $names[$userid->user_id] = Profile::findOne($userid->user_id)->getFullName();
        }
        return $names;
    }

}
