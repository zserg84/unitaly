<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 18.06.15
 * Time: 14:30
 */

namespace modules\directory\models\search;

use modules\directory\Module as DirectoryModule;
use modules\directory\models\Showplace;
use yii\data\ActiveDataProvider;

class ShowplaceSearch extends Showplace
{

    private $_cityName;
    private $_showplaceTypeName;

    public function rules()
    {
        return [
            [['name', 'city_id', 'cityName', 'showplaceTypeName'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return array_merge($labels, [
            'cityName' => DirectoryModule::t('showplace', 'CITY_NAME'),
            'showplaceTypeName' => DirectoryModule::t('showplace', 'SHOWPLACE_TYPE_NAME'),
        ]);
    }

    public function search($params = null){
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
                'id',
                'name' => [
                    'asc' => ['showplace_lang.name' => SORT_ASC],
                    'desc' => ['showplace_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'cityName' => [
                    'asc' => ['city_lang.name' => SORT_ASC],
                    'desc' => ['city_lang.name' => SORT_DESC],
                ],
                'showplaceTypeName' => [
                    'asc' => ['showplace_type_lang.name' => SORT_ASC],
                    'desc' => ['showplace_type_lang.name' => SORT_DESC],
                ],
            ]
        ]);


        if (!($this->load($params) && $this->validate())) {
            $query->innerJoinWith(['city' => function ($q) {
                $q->lang();
            }]);
            $query->innerJoinWith(['showplaceType' => function ($q) {
                $q->lang();
            }]);
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'showplace.id', $this->id]);

        if($this->name)
            $query->andFilterWhere(['LIKE', 'showplace_lang.name', $this->name]);

        $query->innerJoinWith(['city' => function ($q) {
            $q->lang();
            if($this->_cityName)
                $q->andFilterWhere(['LIKE', 'city_lang.name', $this->_cityName]);
        }]);
        $query->innerJoinWith(['showplaceType' => function ($q) {
            $q->lang();
            if($this->_showplaceTypeName)
                $q->andFilterWhere(['=', 'showplace_type.id', $this->_showplaceTypeName]);
//                $q->andFilterWhere(['LIKE', 'showplace_type_lang.name', $this->_showplaceTypeName]);
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

    public function getShowplaceTypeName(){
        if($this->_showplaceTypeName)
            return $this->_showplaceTypeName;
        $showplaceType = $this->showplaceType;
        return $showplaceType ? $showplaceType->name : null;
    }

    public function setShowplaceTypeName($value){
        $this->_showplaceTypeName = $value;
    }
} 