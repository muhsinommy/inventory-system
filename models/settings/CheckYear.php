<?php

namespace app\models\settings;

use Yii;

/**
 * This is the model class for table "check_year".
 *
 * @property int $year_id
 * @property int $year
 */
class CheckYear extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'check_year';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['year'], 'required'],
            [['year'], 'integer'],
            [['year'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'year_id' => 'Year ID',
            'year' => 'Year',
        ];
    }

      public static function getYears() {
        $years = self::find()->all();
        $res = [];
        $res[0] = 'ALL TIME'; 
        foreach ($years as $year):
            $res[$year->year] = $year->year;
        endforeach;
        return $res;
    }
  

}
