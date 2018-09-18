<?php

namespace app\models\config;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $country_id
 * @property string $country_name
 */
class Country extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['country_name'], 'required'],
            [['country_name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'country_id' => 'Country ID',
            'country_name' => 'Country Name',
        ];
    }

    //Returns all countries indexed by their country_id
    public static function getCountries() {

        $countries = self::find()->all();
        $result = [];
        foreach ($countries as $country) {
            $result[$country->country_id] = $country->country_name;
        }
        return $result;
    }

}
