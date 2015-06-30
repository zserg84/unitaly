<?php

namespace modules\directory\models\query;
use modules\translations\models\Lang;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\ShopCategory]].
 *
 * @see \modules\directory\models\ShopCategory
 */
class ShopCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\ShopCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\ShopCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function lang($langId = null){
        if(!$langId){
            $lang = Lang::getCurrent();
            $langId = $lang->id;
        }
        $this->innerJoinWith([
            'shopCategoryLangs' => function($query) use($langId){
                $query->where([
                    'shop_category_lang.lang_id' => $langId,
                ]);
            }
        ]);
        return $this;
    }
}