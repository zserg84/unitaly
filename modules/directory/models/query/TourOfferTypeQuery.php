<?php

namespace modules\directory\models\query;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\TourOfferType]].
 *
 * @see \modules\directory\models\TourOfferType
 */
class TourOfferTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\TourOfferType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\TourOfferType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}