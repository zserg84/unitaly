<?php

namespace modules\directory\models\query;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\ShopScheduleLang]].
 *
 * @see \modules\directory\models\ShopScheduleLang
 */
class ShopScheduleLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\ShopScheduleLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\ShopScheduleLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}