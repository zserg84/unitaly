<?php

namespace modules\directory\models\search;


use modules\directory\models\Region;
use yii\data\ActiveDataProvider;

class RegionSearch extends Region
{
	public $arms_image;

    public function rules()
    {
        return [
            [['id', 'name', 'spellings'], 'safe'],
        ];
    }

    public function search($params = null)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        /*
         * Чтобы корректно сортировалось, добавляем жёсткую связь с таблицей переводов
         * */
        $query->lang();

        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['region.id' => SORT_ASC],
                    'desc' => ['region.id' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'name' => [
                    'asc' => ['region_lang.name' => SORT_ASC],
                    'desc' => ['region_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

	    $query->andFilterWhere(['=', 'region.id', $this->id]);

        if ($this->name)
            $query->andFilterWhere(['LIKE', 'region_lang.name', $this->name]);

        if ($this->description)
            $query->andFilterWhere(['LIKE', 'region_lang.description', $this->description]);

        return $dataProvider;
    }
}
