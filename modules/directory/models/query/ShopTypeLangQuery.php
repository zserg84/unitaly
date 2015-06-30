<?php

namespace modules\directory\models\query;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\ShopTypeLang]].
 *
 * @see \modules\directory\models\ShopTypeLang
 */
class ShopTypeLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\ShopTypeLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\ShopTypeLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}