<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SubCategory;

/**
 * SubCategorySearch represents the model behind the search form about `app\models\SubCategory`.
 */
class SubCategorySearch extends SubCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_id'], 'integer'],
            [['subcat_name', 'subcat_image', 'subcat_status', 'created_at', 'updated_at'], 'safe'],
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
        $query = SubCategory::find();

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
            'cat_id' => $this->cat_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'subcat_status' => $this->subcat_status,
        ]);

        $query->andFilterWhere(['like', 'subcat_name', $this->subcat_name])
            ->andFilterWhere(['like', 'subcat_image', $this->subcat_image]);

        return $dataProvider;
    }
}
