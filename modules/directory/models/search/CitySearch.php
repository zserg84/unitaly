<?php

namespace modules\directory\models\search;


use modules\directory\models\City;
use yii\data\ActiveDataProvider;
use modules\directory\Module as DirectoryModule;

class CitySearch extends City
{
	private $_provinceName, $_regionName;
	public $name;

    public function rules()
    {
        return [
            [['name', 'regionName', 'provinceName', 'id'], 'safe'],
        ];
    }

	public function attributeLabels()
	{
		$labels = parent::attributeLabels();
		return array_merge($labels, [
			'regionName' => DirectoryModule::t('region', 'NAME'),
			'provinceName' => DirectoryModule::t('province', 'NAME'),
		]);
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
		            'asc' => ['city.id' => SORT_ASC],
		            'desc' => ['city.id' => SORT_DESC],
		            'default' => SORT_ASC
	            ],
                'name' => [
                    'asc' => ['city_lang.name' => SORT_ASC],
                    'desc' => ['city_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'provinceName' => [
	                'asc' => ['province_lang.name' => SORT_ASC],
	                'desc' => ['province_lang.name' => SORT_DESC],
                ],
                'regionName' => [
	                'asc' => ['region_lang.name' => SORT_ASC],
	                'desc' => ['region_lang.name' => SORT_DESC],
                ],
            ]
        ]);

	    $query->innerJoinWith(
		    [
			    'province' => function($q) {
				    $q->lang()->innerJoinWith([
						    'region' => function($q) {$q->lang();}
					    ]
				    );
			    }
		    ]
	    );

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

	    $query->andFilterWhere(['=', 'city.id', $this->id]);

	    if ($this->name)
		    $query->andFilterWhere(['LIKE', 'city_lang.name', $this->name]);

	    if ($this->_regionName)
		    $query->andFilterWhere(['LIKE', 'region_lang.name', $this->_regionName]);

	    if ($this->_provinceName)
		    $query->andFilterWhere(['LIKE', 'province_lang.name', $this->_provinceName]);

        return $dataProvider;
    }

	public function getProvinceName(){
		if($this->_provinceName)
			return $this->_provinceName;
		$province = $this->province;
		return $province ? $province->name : null;
	}

	public function setProvinceName($value){
		$this->_provinceName = $value;
	}

	public function getRegionName(){
		if($this->_regionName)
			return $this->_regionName;
		$region = ($this->province) ? $this->province->region : null;
		return $region ? $region->name : null;
	}

	public function setRegionName($value){
		$this->_regionName = $value;
	}

}
