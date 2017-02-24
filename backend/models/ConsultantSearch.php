<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Consultant;
use app\models\SubCategory;

/**
 * ConsultantSearch represents the model behind the search form about `app\models\Consultant`.
 */
class ConsultantSearch extends Consultant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_id', 'qualification_id'], 'integer'],
            [['token_id', 'first_name', 'last_name', 'email', 'password', 'phone', 'profile_image', 'sub_cat_id', 'description', 'status', 'registration_type', 'created_at', 'updated_at'], 'safe'],
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
        $query = Consultant::find();

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
            'qualification_id' => $this->qualification_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'token_id', $this->token_id])
            ->andFilterWhere(['or',
                    ['like', 'first_name', $this->first_name],
                    ['like', 'last_name', $this->first_name],
                    ['like', "concat(first_name, ' ', last_name)", $this->first_name],
                ])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'profile_image', $this->profile_image])
            ->andFilterWhere(['like', 'sub_cat_id', $this->sub_cat_id])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'registration_type', $this->registration_type]);
        //echo $query->createCommand()->getRawSql();
        return $dataProvider;
    }
    
       
}
