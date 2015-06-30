<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 09.06.15
 * Time: 16:23
 */

namespace modules\directory\models\search;

use modules\directory\models\ShowplaceType;
use yii\data\ActiveDataProvider;

class ShowplaceTypeSearch extends ShowplaceType
{
    public function rules()
    {
        return [
            [['id', 'name', 'description'], 'safe'],
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
                    'asc' => ['showplace_type_lang.name' => SORT_ASC],
                    'desc' => ['showplace_type_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'description' => [
                    'asc' => ['showplace_type_lang.description' => SORT_ASC],
                    'desc' => ['showplace_type_lang.description' => SORT_DESC],
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'showplace_type.id', $this->id]);

        if($this->name)
            $query->andFilterWhere(['LIKE', 'showplace_type_lang.name' , $this->name]);
        if($this->description)
            $query->andFilterWhere(['LIKE', 'showplace_type_lang.name' , $this->description]);

        return $dataProvider;
    }
} 