<?php

namespace modules\directory\models\search;


use modules\directory\models\Hub;
use yii\data\ActiveDataProvider;

class HubSearch extends Hub
{
	public $_cityName;

    public function rules()
    {
        return [
            [['id', 'name', 'description', 'cityName'], 'safe'],
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
		            'asc' => ['hub.id' => SORT_ASC],
		            'desc' => ['hub.id' => SORT_DESC],
		            'default' => SORT_ASC
	            ],
                'name' => [
                    'asc' => ['hub_lang.name' => SORT_ASC],
                    'desc' => ['hub_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
	            'cityName' => [
		            'asc' => ['city_lang.name' => SORT_ASC],
		            'desc' => ['city_lang.name' => SORT_DESC],
	            ],
            ]
        ]);

	    $query->innerJoinWith(
		    [
			    'city' => function($q) {
				    $q->lang();
			    }
		    ]
	    );

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

	    $query->andFilterWhere(['=', 'hub.id', $this->id]);

        if ($this->name)
            $query->andFilterWhere(['LIKE', 'hub_lang.name', $this->name]);

        if ($this->_cityName)
            $query->andFilterWhere(['LIKE', 'city_lang.name', $this->_cityName]);

        return $dataProvider;
    }

	public function getCityName(){
		if($this->_cityName)
			return $this->_cityName;
		$city = $this->city;
		return $city ? $city->name : null;
	}

	public function setCityName($value){
		$this->_cityName = $value;
	}

}
