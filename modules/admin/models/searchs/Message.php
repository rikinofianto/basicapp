<?php

namespace app\modules\admin\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Message as MessageModel;
use app\modules\admin\models\MessageBox;

/**
 * Message represents the model behind the search form about `app\modules\admin\models\Message`.
 */
class Message extends Model
{
    public $message_id;
    public $subject;
    public $message;
    public $destination_type;
    public $destination;
    public $created_at;
    public $updated_at;

        /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id'], 'integer'],
            [['subject', 'message', 'destination_type', 'destination', 'created_at', 'updated_at'], 'safe'],
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
        $query = MessageModel::find();

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
            'message_id' => $this->message_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'destination_type', $this->destination_type])
            ->andFilterWhere(['like', 'destination', $this->destination]);
            // ->andFilterWhere(['like', 'is_draft', $this->is_draft])
            // ->andFilterWhere(['like', 'is_deleted', $this->is_deleted])
            // ->andFilterWhere(['like', 'created_by', $this->created_by])
            // ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
