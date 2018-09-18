<?php

namespace app\models;

use Yii;
use app\models\validators\NameValidator;

/**
 * This is the model class for table "supplier".
 *
 * @property int $supplier_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $address
 */
class Supplier extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'phone', 'email', 'address'], 'required'],
            [['phone'], 'string', 'max' => 16],
            [['email', 'address'], 'string', 'max' => 128],
            ['phone', \miserenkov\validators\PhoneValidator::className(), 'country' => 'TZ'],
            [['email'], 'email', 'message' => 'Email address is invalid!'],
            [['email'], 'unique', 'message' => 'Email address is in use!'],
            [['phone'], 'unique', 'message' => 'Phone number is in use!'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'supplier_id' => 'Supplier ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'address' => 'Address',
        ];
    }

    //Counts Product Suppliers
    public static function getCount() {
        return self::find()->count();
    }

    //Returns Supplier indexed by their Names
    public static function getSuppliers() {
        $suppliers = self::find()->all();
        $result = [];
        foreach ($suppliers as $supplier) {
            $result[$supplier->supplier_id] = $supplier->name;
        }
        return $result;
    }

}
