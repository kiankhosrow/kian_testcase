<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Message;
use Yii;
/**
 * MessageSearch represents the model behind the search form of `app\models\Message`.
 */
class MessageSearch extends Message
{
    /**
     * {@inheritdoc}
     */
    public $first_name,$last_name;
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['message','first_name'], 'safe'],
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
        $query = Message::find()->with('user');

        $user_id = Yii::$app->user->identity->id;

        if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'])
            $query->where(['user_id'=>$_REQUEST['user_id']]);
        else
            $query->where(['user_id'=>$user_id]);

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
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);

        $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
