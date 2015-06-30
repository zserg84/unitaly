<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.06.15
 * Time: 11:26
 */

namespace modules\directory\models\search;


use modules\directory\models\ShopCategory;
use modules\directory\models\ShopType;
use yii\data\ActiveDataProvider;

class ShopCategorySearch extends ShopCategory
{

    protected  $_shop_type_id = ShopType::TYPE_STORE;

    public function rules()
    {
        return [
            [['id', 'name'], 'safe'],
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
        $query->andFilterWhere(['=', 'shop_category.shop_type_id', $this->_shop_type_id]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name' => [
                    'asc' => ['shop_category_lang.name' => SORT_ASC],
                    'desc' => ['shop_category_lang.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'shop_category.id', $this->id]);

        if($this->name)
            $query->andFilterWhere(['LIKE', 'shop_category_lang.name', $this->name]);

        return $dataProvider;
    }
} 