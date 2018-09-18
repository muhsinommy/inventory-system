<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $product_id
 * @property int $category
 * @property int $details
 * @property int $status
 * @property int $supplier
 * @property int $is_purchased
 * @property double $price
 */
class Product extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['category', 'supplier', 'price', 'details'], 'required'],
            [['category', 'status', 'supplier', 'is_purchased'], 'integer'],
            [['price'], 'number'],
            [['details'], 'string'],
            [['details'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'product_id' => 'Product ID',
            'category' => 'Category',
            'details' => 'Description',
            'status' => 'Status',
            'supplier' => 'Supplier',
            'is_purchased' => 'Source',
            'price' => 'Price',
        ];
    }

    //Returns number of all kinds of Products
    public static function getProductCount() {
        return self::find()->count();
    }

}
