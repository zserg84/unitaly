<?php

namespace modules\directory\models\query;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\ShowplaceLang]].
 *
 * @see \modules\directory\models\ShowplaceLang
 */
class ShowplaceLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\ShowplaceLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\ShowplaceLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}