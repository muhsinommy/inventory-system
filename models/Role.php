<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property int $role_id
 * @property int $role_code
 * @property string $role_desc
 *
 * @property CanPerform[] $canPerforms
 * @property User[] $users
 */
class Role extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'role';
    }

    /*     * User Role Codes* */

    const SYSTEM_ADMIN = 1;
    const PROPERTY_VALUER = 2;
    const PROPERTY_VALUER_IN_CHARGE = 3;
    const TRA_OFFICER = 4;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['role_code', 'role_name', 'role_desc'], 'required'],
            [['role_code'], 'integer'],
            [['role_name'], 'string', 'max' => 50],
            [['role_desc'], 'string', 'max' => 128],
            [['role_code', 'role_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'role_id' => 'Role ID',
            'role_code' => 'Role Code',
            'role_name' => 'Role Name',
            'role_desc' => 'Role Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCanPerforms() {
        return $this->hasMany(CanPerform::className(), ['role' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(User::className(), ['role' => 'role_id']);
    }

    //Returns Array of role_desc indexed by role_id
    public static function getRoles() {
        $result = [];
        foreach (self::find()->all() as $role) {
            if ($role->role_code == self::TRA_OFFICER || $role->role_code == self::PROPERTY_VALUER_IN_CHARGE) {
                continue;
            } else {
                $result[$role->role_id] = $role->role_desc;
            }
        }
        return $result;
    }

    //Returns number of User Roles
    public static function getNumRoles() {
        return self::find()->where([
                    '!=', 'role_code', 3
                ])->andWhere([
                    '!=', 'role_code', 4
                ])->count();
    }
   

}
