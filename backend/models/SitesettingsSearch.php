<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sitesettings;

/**
 * SitesettingsSearch represents the model behind the search form about `app\models\Sitesettings`.
 */
class SitesettingsSearch extends Sitesettings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['sitesettings_name', 'sitesettings_type', 'sitesettings_data_type', 'sitesettings_lebel', 'sitesettings_value', 'status', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Sitesettings::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'sitesettings_name', $this->sitesettings_name])
            ->andFilterWhere(['like', 'sitesettings_type', $this->sitesettings_type])
            ->andFilterWhere(['like', 'sitesettings_data_type', $this->sitesettings_data_type])
            ->andFilterWhere(['like', 'sitesettings_lebel', $this->sitesettings_lebel])
            ->andFilterWhere(['like', 'sitesettings_value', $this->sitesettings_value])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
