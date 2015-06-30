<?php

namespace modules\translations\models\query;

/**
 * This is the ActiveQuery class for [[\modules\translations\models\Lang]].
 *
 * @see \modules\translations\models\Lang
 */
class LangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\translations\models\Lang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\translations\models\Lang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}