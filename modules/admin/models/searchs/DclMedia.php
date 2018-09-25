<?php

namespace app\modules\admin\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\DclMedia as DclMediaModel;

/**
 * DclMedia represents the model behind the search form about `app\modules\admin\models\DclMedia`.
 */
class DclMedia extends DclMediaModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['media_id', 'created', 'updated', 'type'], 'integer'],
            [['name', 'desc', 'setting', 'path_name', 'create_by', 'privilege', 'size', 'position', 'group'], 'safe'],
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
        $query = DclMediaModel::find();

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
            'media_id' => $this->media_id,
            'created' => $this->created,
            'updated' => $this->updated,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'setting', $this->setting])
            ->andFilterWhere(['like', 'path_name', $this->path_name])
            ->andFilterWhere(['like', 'create_by', $this->create_by])
            ->andFilterWhere(['like', 'privilege', $this->privilege])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'group', $this->group]);

        return $dataProvider;
    }
}
