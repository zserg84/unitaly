<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 10.06.15
 * Time: 15:42
 */

namespace modules\directory\models\search;

use modules\directory\Module as DirectoryModule;
use modules\directory\models\Tour;
use yii\data\ActiveDataProvider;

class TourSearch extends Tour
{

    private $_tourTypeName;

    public function rules()
    {
        return [
            [['id', 'name', 'tourTypeName', 'frontend'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return array_merge($labels, [
            'tourTypeName' => DirectoryModule::t('tour', 'TOUR_TYPE_ID'),
            'name' => DirectoryModule::t('tour', 'NAME'),
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
                    'asc' => ['tour_lang.name' => SORT_ASC],
                    'desc' => ['tour_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'tourTypeName' => [
                    'asc' => ['tour_type_lang.name' => SORT_ASC],
                    'desc' => ['tour_type_lang.name' => SORT_DESC],
                ],
                'frontend'
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->innerJoinWith(['tourType' => function ($q) {
                $q->lang();
            }]);
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'id', $this->id]);
        $query->andFilterWhere(['LIKE', 'tour_lang.name' , $this->name]);
        $query->andFilterWhere(['=', 'tour.frontend' , $this->frontend]);

        $query->innerJoinWith(['tourType' => function ($q) {
            $q->lang();
            if($this->_tourTypeName)
                $q->andFilterWhere(['=', 'tour_type.id', $this->_tourTypeName]);
//                $q->andFilterWhere(['LIKE', 'tour_type_lang.name', $this->_tourTypeName]);
        }]);

        return $dataProvider;
    }

    public function getTourTypeName(){
        if($this->_tourTypeName)
            return $this->_tourTypeName;
        $tourType = $this->tourType;
        return $tourType ? $tourType->name : null;
    }

    public function setTourTypeName($value){
        $this->_tourTypeName = $value;
    }
}
