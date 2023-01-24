<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Page;

/**
 * PageSearch represents the model behind the search form of `common\models\Page`.
 */
class PageSearch extends Page
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'parent_id', 'page_order', 'status', 'page_type', 'show_on_footer', 'show_on_header', 'created_at', 'updated_at','is_delete'], 'integer'],
            [['slug', 'external_url'], 'safe'],
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
        $query = Page::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['page_id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'page_id' => $this->page_id,
            'parent_id' => $this->parent_id,
            'page_order' => $this->page_order,
            'status' => $this->status,
            'page_type' => $this->page_type,
            'show_on_footer' => $this->show_on_footer,
            'show_on_header' => $this->show_on_header,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_delete' => $this->is_delete,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'external_url', $this->external_url]);

        return $dataProvider;
    }
}
