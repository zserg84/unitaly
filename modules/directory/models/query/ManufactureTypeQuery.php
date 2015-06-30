<?php

namespace modules\directory\models\query;
use modules\translations\models\Lang;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\ManufactureType]].
 *
 * @see \modules\directory\models\ManufactureType
 */
class ManufactureTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\ManufactureType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\ManufactureType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function lang($langId = null){
        if(!$langId){
            $lang = Lang::getCurrent();
            $langId = $lang->id;
        }
        $this->innerJoinWith([
            'manufactureTypeLangs' => function($query) use($langId){
                $query->where([
                    'manufacture_type_lang.lang_id' => $langId,
                ]);
            }
        ]);
        return $this;
    }
}