<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_details".
 *
 * @property int $product_id
 * @property int $make
 * @property int $type
 * @property int $model
 * @property int $color
 */
class ProductDetails extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'product_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['product_id', 'make', 'model'], 'required'],
            [['product_id','model', 'make', 'type', 'color'], 'integer'],
            [['product_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'product_id' => 'Product ID',
            'make' => 'Make',
            'type' => 'Type',
            'model' => 'Model',
            'color' => 'Color',
        ];
    }
}
