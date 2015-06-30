<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 22.06.15
 * Time: 13:03
 */

namespace modules\directory\models\search;

use modules\directory\Module as DirectoryModule;
use modules\directory\models\Cafe;
use yii\data\ActiveDataProvider;

class CafeSearch extends Cafe
{

    private $_cityName;

    public function rules()
    {
        return [
            [['id', 'name', 'cityName', 'frontend'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return array_merge($labels, [
            'cityName' => DirectoryModule::t('city', 'NAME'),
        ]);
    }

    public function search($params = null)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name' => [
                    'asc' => ['cafe_lang.name' => SORT_ASC],
                    'desc' => ['cafe_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'cityName' => [
                    'asc' => ['city_lang.name' => SORT_ASC],
                    'desc' => ['city_lang.name' => SORT_DESC],
                ],
            ]
        ]);

        $query->lang();
        if (!($this->load($params) && $this->validate())) {
            $query->innerJoinWith(['city' => function ($q) {
                $q->lang();
            }]);
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'cafe.id', $this->id]);

        $query->andFilterWhere(['LIKE', 'cafe_lang.name', $this->name]);
        $query->andFilterWhere(['=', 'cafe.frontend' , $this->frontend]);
        $query->innerJoinWith(['city' => function ($q) {
            $q->lang();
            if($this->_cityName)
                $q->andFilterWhere(['LIKE', 'city_lang.name', $this->_cityName]);
        }]);

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