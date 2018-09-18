<?php

namespace app\models\settings;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property int $settings_id
 * @property int $userid
 * @property int $active_year
 */
class Settings extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['userid', 'active_year'], 'required'],
            ['userid', 'unique'],
            [['userid', 'active_year'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'settings_id' => 'Settings ID',
            'userid' => 'Userid',
            'active_year' => 'Active Year',
        ];
    }

    public static function getActiveYear() {
        $userid = \Yii::$app->user->id;
        $settings = self::findOne(['userid' => $userid]);
        if ($settings === null):
            return date('Y');
        endif;
        return $settings->active_year;
    }

}
