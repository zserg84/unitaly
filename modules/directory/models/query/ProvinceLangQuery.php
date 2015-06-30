<?php

namespace modules\directory\models\query;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\ProvinceLang]].
 *
 * @see \modules\directory\models\ProvinceLang
 */
class ProvinceLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\ProvinceLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\ProvinceLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}