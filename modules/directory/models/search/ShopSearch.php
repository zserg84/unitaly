<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 24.06.15
 * Time: 14:21
 */

namespace modules\directory\models\search;

use modules\directory\Module as DirectoryModule;
use modules\directory\models\Shop;
use yii\data\ActiveDataProvider;

class ShopSearch extends Shop
{
    private $_cityName;
    private $_shopTypeName;

    public function rules()
    {
        return [
            [['name', 'cityName', 'frontend', 'shopTypeName'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return array_merge($labels, [
            'cityName' => DirectoryModule::t('shop', 'CITY_NAME'),
            'shopTypeName' => DirectoryModule::t('shop', 'SHOP_TYPE_NAME'),
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
                'id',
                'name' => [
                    'asc' => ['shop_lang.name' => SORT_ASC],
                    'desc' => ['shop_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'cityName' => [
                    'asc' => ['city_lang.name' => SORT_ASC],
                    'desc' => ['city_lang.name' => SORT_DESC],
                ],
                'frontend',
                'shopTypeName' => [
                    'asc' => ['shop_type_lang.name' => SORT_ASC],
                    'desc' => ['shop_type_lang.name' => SORT_DESC],
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->innerJoinWith(['city' => function ($q) {
                $q->lang();
            }]);
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'id', $this->id]);
        $query->andFilterWhere(['=', 'shop_type_id', $this->shop_type_id]);
        $query->andFilterWhere(['=', 'shop.frontend' , $this->frontend]);
        $query->andFilterWhere(['=', 'shop.shop_type_id', $this->_shopTypeName]);

        if ($this->name)
            $query->andFilterWhere(['LIKE', 'shop_lang.name', $this->name]);

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

    public function getShopTypeName(){
        if($this->_shopTypeName)
            return $this->_shopTypeName;
        $shopType = $this->shopType;
        return $shopType ? $shopType->name : null;
    }

    public function setShopTypeName($value){
        $this->_shopTypeName = $value;
    }
} 