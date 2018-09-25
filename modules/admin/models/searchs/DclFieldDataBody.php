<?php

namespace app\modules\admin\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\DclFieldDataBody as DclFieldDataBodyModel;

/**
 * DclFieldDataBody represents the model behind the search form about `app\modules\admin\models\DclFieldDataBody`.
 */
class DclFieldDataBody extends DclFieldDataBodyModel
{
    public $changed; //related from DclNode, used for searching
    public $status; //related from DclNode, used for searching
    public $publish; //related from DclNode, used for searching
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'deleted', 'node_id', 'delta'], 'integer'],
            [['node_type', 'bundle', 'language', 'title', 'body_value', 'body_summary', 'body_format', 'meta_tag', 'slideshow','changed','status','publish'], 'safe'],
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
        $query = DclFieldDataBodyModel::find();
        // $query->joinWith('dcl_node');
        $query->leftJoin('dcl_node','dcl_field_data_body.node_id = dcl_node.node_id');
        // $query->orderBy('dcl_node.changed');



        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'sort' => [
            //     'defaultOrder' => [
            //         'dcl_node.changed' => SORT_DESC,
            //     ],
            // ]

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
            'deleted' => $this->deleted,
            'node_id' => $this->node_id,
            'delta' => $this->delta,
        ]);

        $query->andFilterWhere(['like', 'dcl_field_data_body.node_type', $this->node_type])
            ->andFilterWhere(['like', 'bundle', $this->bundle])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body_value', $this->body_value])
            ->andFilterWhere(['like', 'body_summary', $this->body_summary])
            ->andFilterWhere(['like', 'body_format', $this->body_format])
            ->andFilterWhere(['like', 'meta_tag', $this->meta_tag])
            ->andFilterWhere(['like', 'slideshow', $this->slideshow])
            ->andFilterWhere(['like', 'dcl_node.status', $this->status])
            ->andFilterWhere(['like', 'dcl_node.publish', $this->publish])
            ;

        if ($this->changed) {
            $query->andFilterWhere(['like', 'DATE_FORMAT(FROM_UNIXTIME(dcl_node.changed), "%Y-%m-%d")', Date("Y-m-d", strtotime($this->changed))]);
        }

        return $dataProvider;
    }
}
