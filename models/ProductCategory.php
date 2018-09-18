<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_category".
 *
 * @property int $category_id
 * @property string $category_desc
 */
class ProductCategory extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'product_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['category_desc'], 'required'],
            [['category_desc'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'category_id' => 'Category ID',
            'category_desc' => 'Category Description',
        ];
    }

    //Counts Product Categories
    public static function getCount() {
        return self::find()->count();
    }

    //Returns Product Categories Indexed by their ids
    public static function getCategories() {
        $categories = self::find()->all();
        $result = [];
        foreach ($categories as $category) {
            $result[$category->category_id] = $category->category_desc;
        }
        return $result;
    }

}
