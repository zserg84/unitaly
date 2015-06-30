<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 03.02.15
 * Time: 10:22
 */

namespace modules\translations\models\search;


use modules\translations\models\Lang;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

class LangSearch extends Lang{

    public function rules() {
        return [
            [['url', 'local', 'name', 'date_update', 'date_create'], 'safe'],
            [['created_at', 'updated_at'], 'date', 'format' => 'd.m.Y']
        ];
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params Search params
     *
     * @return ActiveDataProvider DataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'FROM_UNIXTIME(created_at, "%d.%m.%Y")' => $this->created_at,
                'FROM_UNIXTIME(updated_at, "%d.%m.%Y")' => $this->updated_at
            ]
        );

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'url', $this->url]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'local', $this->local]);

        return $dataProvider;
    }
} 