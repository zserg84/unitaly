<?php

namespace modules\directory\models\search;


use modules\directory\models\AdditionalService;
use yii\data\ActiveDataProvider;

class AdditionalServiceSearch extends AdditionalService
{
	public $name;
	public $description;
	public $category;

    public function rules()
    {
        return [
            [['name', 'description'], 'safe'],
        ];
    }

    public function search($params = null)
    {
        $query = self::find()->joinWith('serviceType');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        /*
         * Чтобы корректно сортировалось, добавляем жёсткую связь с таблицей переводов
         * */
        $query->lang();

        $dataProvider->setSort([
            'attributes' => [
                'name' => [
                    'asc' => ['additional_service_lang.name' => SORT_ASC],
                    'desc' => ['additional_service_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);

	    $query->andWhere('service_type.category_id=:categoryId', ['categoryId' => $this->category]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->name)
            $query->andFilterWhere(['LIKE', 'additional_service_lang.name', $this->name]);

        if ($this->description)
            $query->andFilterWhere(['LIKE', 'additional_service_lang.description', $this->description]);

        return $dataProvider;
    }
}
