<?php

namespace modules\directory\models\query;

/**
 * This is the ActiveQuery class for [[\modules\ShowplaceTypeLang]].
 *
 * @see \modules\ShowplaceTypeLang
 */
class ShowplaceTypeLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\ShowplaceTypeLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\ShowplaceTypeLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}