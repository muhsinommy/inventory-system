<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductModel;

/**
 * ProductModelSearch represents the model behind the search form of `app\models\ProductModel`.
 */
class ProductModelSearch extends ProductModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id', 'make'], 'integer'],
            [['model_desc'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProductModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'model_id' => $this->model_id,
            'make' => $this->make,
        ]);

        $query->andFilterWhere(['like', 'model_desc', $this->model_desc]);

        return $dataProvider;
    }
}
