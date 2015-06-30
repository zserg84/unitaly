<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 19.06.15
 * Time: 14:04
 */

namespace modules\directory\models\search;

use modules\directory\Module as DirectoryModule;
use modules\directory\models\Province;
use yii\data\ActiveDataProvider;

class ProvinceSearch extends Province
{
    private $_regionName;
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name', 'description', 'regionName'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return array_merge($labels, [
            'regionName' => DirectoryModule::t('region', 'NAME'),
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
                    'asc' => ['province_lang.name' => SORT_ASC],
                    'desc' => ['province_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'regionName' => [
                    'asc' => ['region_lang.name' => SORT_ASC],
                    'desc' => ['region_lang.name' => SORT_DESC],
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'id', $this->id]);

        if ($this->name)
            $query->andFilterWhere(['LIKE', 'province_lang.name', $this->name]);

        $query->innerJoinWith(['region' => function ($q) {
            $q->lang();
            if($this->_regionName)
                $q->andFilterWhere(['LIKE', 'region_lang.name', $this->_regionName]);
        }]);
        return $dataProvider;
    }

    public function getRegionName(){
        if($this->_regionName)
            return $this->_regionName;
        $region = $this->region;
        return $region ? $region->name : null;
    }

    public function setRegionName($value){
        $this->_regionName = $value;
    }
} 