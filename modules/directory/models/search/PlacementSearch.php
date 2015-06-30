<?php

namespace modules\directory\models\search;


use modules\directory\models\Placement;
use yii\data\ActiveDataProvider;

class PlacementSearch extends Placement
{
    public function rules()
    {
        return [
            [['id', 'name'], 'safe'],
        ];
    }

    public function search($params = null)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->lang();

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name' => [
                    'asc' => ['placement_lang.name' => SORT_ASC],
                    'desc' => ['placement_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->innerJoinWith(['placementLangs']);
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'id', $this->id]);

        $query->innerJoinWith(['placementLangs' => function ($q) {
            if ($this->name)
                $q->where('placement_lang.name LIKE "%' . $this->name . '%"');
        }]);

        return $dataProvider;
    }
}
