<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 30.06.15
 * Time: 10:24
 */

namespace modules\directory\models\search;


use modules\directory\models\ManufactureType;
use yii\data\ActiveDataProvider;

class ManufactureTypeSearch extends ManufactureType
{
    public function rules()
    {
        return [
            [['id', 'name'], 'safe'],
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
                'id',
                'name' => [
                    'asc' => ['manufacture_type_lang.name' => SORT_ASC],
                    'desc' => ['manufacture_type_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'id', $this->id]);
        $query->andFilterWhere(['LIKE', 'manufacture_type_lang.name' , $this->name]);

        return $dataProvider;
    }
} 