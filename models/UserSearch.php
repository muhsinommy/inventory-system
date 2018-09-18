<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'role', 'is_active', 'registered_by', 'updated_by'], 'integer'],
            [['user_name', 'password', 'password_hash', 'access_token', 'auth_key', 'last_login', 'date_registered', 'date_updated'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = User::find();

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
            'user_id' => $this->user_id,
            'role' => $this->role,
            'last_login' => $this->last_login,
            'is_active' => $this->is_active
        ]);

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
                ->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'access_token', $this->access_token])
                ->andFilterWhere(['like', 'auth_key', $this->auth_key]);


        $query->orderBy(['date_updated' => SORT_DESC]);

       

        return $dataProvider;
    }

}
