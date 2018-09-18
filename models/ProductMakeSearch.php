<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductMake;

/**
 * ProductMakeSearch represents the model behind the search form of `app\models\ProductMake`.
 */
class ProductMakeSearch extends ProductMake
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['make_id', 'country'], 'integer'],
            [['make_desc', 'logo'], 'safe'],
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
        $query = ProductMake::find();

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
            'make_id' => $this->make_id,
            'country' => $this->country,
        ]);

        $query->andFilterWhere(['like', 'make_desc', $this->make_desc])
            ->andFilterWhere(['like', 'logo', $this->logo]);

        return $dataProvider;
    }
}
