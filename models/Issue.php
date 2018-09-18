<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "issue".
 *
 * @property int $issue_id
 * @property int $user_id
 * @property string $action
 * @property int $viewed
 * @property string $description
 * @property string $reported_at
 */
class Issue extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    const VIEWED = 1;
    const NOT_VIEWED = 0;
    const ERROR_LOGIN_FAILURE = "Login Failure";
    const ERROR_INACTIVE_ACCOUNT = "Inactive Account";
    const ERROR_ACCESS_DINED = "Access Denied";
    const ERROR_SESSION_TIME_OUT = "Session Time Out";

    public static function tableName() {
        return 'issue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'action', 'description'], 'required'],
            [['user_id', 'viewed'], 'integer'],
            [['reported_at'], 'safe'],
            [['action', 'description'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'issue_id' => 'Issue ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'viewed' => 'Viewed',
            'description' => 'Description',
            'reported_at' => 'Reported At',
        ];
    }

    //Counts non Viewed Reported issues
    public static function getNonViewedCount() {
        $query = self::find()->where([
            'viewed' => self::NOT_VIEWED,
        ]);
        $query->andWhere(['like', 'reported_at', settings\Settings::getActiveYear()]);
        return $query->count();
    }

    //Returns Failure List
    public static function getFailures() {
        return [
            self::ERROR_ACCESS_DINED => self::ERROR_ACCESS_DINED,
            self::ERROR_LOGIN_FAILURE => self::ERROR_LOGIN_FAILURE,
            self::ERROR_INACTIVE_ACCOUNT => self::ERROR_INACTIVE_ACCOUNT,
            self::ERROR_SESSION_TIME_OUT => self::ERROR_SESSION_TIME_OUT,
        ];
    }

}
