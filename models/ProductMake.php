<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_make".
 *
 * @property int $make_id
 * @property string $make_desc
 * @property int $country
 * @property string $logo
 */
class ProductMake extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'product_make';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['make_desc', 'country'], 'required'],
            [['country'], 'integer'],
            [['make_desc', 'logo'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'make_id' => 'Make ID',
            'make_desc' => 'Make Name',
            'country' => 'Country',
            'logo' => 'Logo',
        ];
    }

    //Counts Product Makes
    public static function getCount() {
        return self::find()->count();
    }

    //Returns Logo for the Product Make or Default if no logo is found
    public function getLogo() {
        if (empty($this->logo)) {
            return 'images/no_logo.png';
        }
        return $this->logo;
    }

    //Returns Product Makes indexed by their ids
    public static function getMakes() {
        $makes = self::find()->all();
        $result = [];
        foreach ($makes as $make) {
            $result[$make->make_id] = $make->make_desc;
        }
        return $result;
    }

}
