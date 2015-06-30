<?php

namespace modules\image\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Image]].
 *
 * @see \common\models\Image
 */
class ImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\image\models\Image[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\image\models\Image|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}