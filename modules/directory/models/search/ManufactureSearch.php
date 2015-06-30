<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 29.06.15
 * Time: 16:45
 */

namespace modules\directory\models\search;

use modules\directory\Module as DirectoryModule;
use modules\directory\models\Manufacture;
use yii\data\ActiveDataProvider;

class ManufactureSearch extends Manufacture
{
    private $_manufactureTypeName;

    public function rules()
    {
        return [
            [['id', 'name', 'manufactureTypeName', 'frontend'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return array_merge($labels, [
            'manufactureTypeName' => DirectoryModule::t('manufacture', 'MANUFACTURE_TYPE_ID'),
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
                    'asc' => ['manufacture_lang.name' => SORT_ASC],
                    'desc' => ['manufacture_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'manufactureTypeName' => [
                    'asc' => ['manufacture_type_lang.name' => SORT_ASC],
                    'desc' => ['manufacture_type_lang.name' => SORT_DESC],
                ],
                'frontend'
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->innerJoinWith(['manufactureType' => function ($q) {
                $q->lang();
            }]);
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'id', $this->id]);
        $query->andFilterWhere(['LIKE', 'manufacture_lang.name' , $this->name]);
        $query->andFilterWhere(['=', 'manufacture.frontend' , $this->frontend]);

        $query->innerJoinWith(['manufactureType' => function ($q) {
            $q->lang();
            if($this->_manufactureTypeName)
                $q->andFilterWhere(['=', 'manufacture_type.id', $this->_manufactureTypeName]);
        }]);

        return $dataProvider;
    }

    public function getManufactureTypeName(){
        if($this->_manufactureTypeName)
            return $this->_manufactureTypeName;
        $manufactureType = $this->manufactureType;
        return $manufactureType ? $manufactureType->name : null;
    }

    public function setManufactureTypeName($value){
        $this->_manufactureTypeName = $value;
    }
} 