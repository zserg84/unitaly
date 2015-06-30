<?php

namespace modules\directory\models\query;
use modules\translations\models\Lang;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\Cafe]].
 *
 * @see \modules\directory\models\Cafe
 */
class CafeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\Cafe[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\Cafe|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /*
	 * Привязываем переводы с указанным языком
	 * */
    public function lang($langId = null){
        if(!$langId){
            $lang = Lang::getCurrent();
            $langId = $lang->id;
        }
        $this->innerJoinWith([
            'cafeLangs' => function($query) use($langId){
                $query->where([
                    'cafe_lang.lang_id' => $langId,
                ]);
            }
        ]);
        return $this;
    }
}