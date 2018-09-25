<?php

namespace app\modules\admin\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Group as GroupModel;

/**
 * Group represents the model behind the search form about `mdm\admin\models\Group`.
 */
class Group extends GroupModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'name', 'detail', 'configuration', 'parent_id', 'path', 'url'], 'safe'],
            [['level', 'order', 'left', 'right'], 'integer'],
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
        $query = GroupModel::find();

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
            'level' => $this->level,
            'order' => $this->order,
            'left' => $this->left,
            'right' => $this->right,
        ]);

        $query->andFilterWhere(['like', 'group_id', $this->group_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'configuration', $this->configuration])
            ->andFilterWhere(['like', 'parent_id', $this->parent_id])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }

    public function getAllByAttr($data){
        var_dump(Group::find()->where(['like', 'group_id', $data['group_id']])->all());exit;
    }
}
