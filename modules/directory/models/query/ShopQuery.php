<?php

namespace modules\directory\models\query;
use modules\directory\models\ShopType;
use modules\translations\models\Lang;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\Shop]].
 *
 * @see \modules\directory\models\Shop
 */
class ShopQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\Shop[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\Shop|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function outlet(){
        $this->andWhere('shop_type_id = :type', [
            'type' => ShopType::TYPE_OUTLET,
        ]);
    }

    public function moll(){
        $this->andWhere('shop_type_id = :type', [
            'type' => ShopType::TYPE_MOLL,
        ]);
    }

    public function supermarket(){
        $this->andWhere('shop_type_id = :type', [
            'type' => ShopType::TYPE_SUPERMARKET,
        ]);
    }

    public function shop(){
        $this->andWhere('shop_type_id = :type', [
            'type' => ShopType::TYPE_SHOP,
        ]);
    }

    public function market(){
        $this->andWhere('shop_type_id = :type', [
            'type' => ShopType::TYPE_MARKET,
        ]);
    }

    public function lang($langId = null){
        if(!$langId){
            $lang = Lang::getCurrent();
            $langId = $lang->id;
        }
        $this->innerJoinWith([
            'shopLangs' => function($query) use($langId){
                $query->where([
                    'shop_lang.lang_id' => $langId,
                ]);
            }
        ]);
        return $this;
    }
}