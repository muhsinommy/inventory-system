<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_model".
 *
 * @property int $model_id
 * @property int $make
 * @property string $model_desc
 */
class ProductModel extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'product_model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['make', 'model_desc'], 'required'],
            [['make'], 'integer'],
            [['model_desc'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'model_id' => 'Model ID',
            'make' => 'Make',
            'model_desc' => 'Model Name',
        ];
    }

    //Counts Product Models
    public static function getCount() {
        return self::find()->count();
    }

    //Returns all Product Models Indexed by their ids
    public static function getModels() {
        $models = self::find()->all();
        $result = [];
        foreach ($models as $model) {
            $result[$model->model_id] = $model->model_desc;
        }
        return $result;
    }

}
