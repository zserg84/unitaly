<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 09.06.15
 * Time: 15:28
 */

namespace modules\directory\models\search;

use modules\directory\models\TourType;
use yii\data\ActiveDataProvider;

class TourTypeSearch extends TourType
{

    public function rules()
    {
        return [
            [['id', 'description', 'name'], 'safe'],
        ];
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
                    'asc' => ['tour_type_lang.name' => SORT_ASC],
                    'desc' => ['tour_type_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'description' => [
                    'asc' => ['tour_type_lang.description' => SORT_ASC],
                    'desc' => ['tour_type_lang.description' => SORT_DESC],
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'tour_type.id', $this->id]);

        if($this->name)
            $query->andFilterWhere(['LIKE', 'tour_type_lang.name', $this->name]);
        if($this->description)
            $query->andFilterWhere(['LIKE', 'tour_type_lang.name', $this->description]);

//        VarDumper::dump($dataProvider->getModels(),10,1);
        return $dataProvider;
    }

} 