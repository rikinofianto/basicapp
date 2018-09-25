<?php

namespace app\modules\admin\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\DclNodeType as DclNodeTypeModel;

/**
 * DclNodeType represents the model behind the search form about `app\modules\admin\models\DclNodeType`.
 */
class DclNodeType extends DclNodeTypeModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['node_type', 'name', 'module', 'description'], 'safe'],
            [['created'], 'integer'],
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
        $query = DclNodeTypeModel::find();

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
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'node_type', $this->node_type])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'module', $this->module])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
