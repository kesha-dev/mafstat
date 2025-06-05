<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GamePlayer;

/**
 * GamePlayerSearch represents the model behind the search form of `common\models\GamePlayer`.
 */
class GamePlayerSearch extends GamePlayer
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'player_id', 'game_id', 'result_string', 'penalty_string', 'role', 'pu'], 'integer'],
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
        $query = GamePlayer::find();

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
            'id' => $this->id,
            'player_id' => $this->player_id,
            'game_id' => $this->game_id,
            'result_string' => $this->result_string,
            'penalty_string' => $this->penalty_string,
            'role' => $this->role,
            'pu' => $this->pu,
        ]);

        return $dataProvider;
    }
}
