<?php

namespace modules\directory\models\query;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\PlacementTypeLang]].
 *
 * @see \modules\directory\models\PlacementTypeLang
 */
class PlacementTypeLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\PlacementTypeLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\PlacementTypeLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}