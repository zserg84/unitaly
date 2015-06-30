<?php

namespace modules\directory\models\query;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\GoodCategoryLang]].
 *
 * @see \modules\directory\models\GoodCategoryLang
 */
class GoodCategoryLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\GoodCategoryLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\GoodCategoryLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}