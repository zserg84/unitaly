<?php

namespace modules\directory\models\query;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\ManufactureLang]].
 *
 * @see \modules\directory\models\ManufactureLang
 */
class ManufactureLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\ManufactureLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\ManufactureLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}