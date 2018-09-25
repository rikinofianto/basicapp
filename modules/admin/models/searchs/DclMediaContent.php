<?php

namespace app\modules\admin\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\DclMediaContent as DclMediaContentModel;

/**
 * DclMediaContent represents the model behind the search form about `app\modules\admin\models\DclMediaContent`.
 */
class DclMediaContent extends DclMediaContentModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['media_content_id', 'parent_id', 'created', 'updated', 'type'], 'integer'],
            [['create_by', 'path', 'DESC', 'setting'], 'safe'],
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
        $query = DclMediaContentModel::find();

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
            'media_content_id' => $this->media_content_id,
            'parent_id' => $this->parent_id,
            'created' => $this->created,
            'updated' => $this->updated,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'create_by', $this->create_by])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'DESC', $this->DESC])
            ->andFilterWhere(['like', 'setting', $this->setting]);

        return $dataProvider;
    }
}
