<?php

namespace modules\directory\models\query;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\ManufactureTypeLang]].
 *
 * @see \modules\directory\models\ManufactureTypeLang
 */
class ManufactureTypeLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\ManufactureTypeLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\ManufactureTypeLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}