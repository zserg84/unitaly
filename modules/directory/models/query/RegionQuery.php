<?php

namespace modules\directory\models\query;
use modules\translations\models\Lang;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\Region]].
 *
 * @see \modules\directory\models\Region
 */
class RegionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\Region[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\Region|array|null
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
			'regionLangs' => function($query) use($langId){
				$query->where([
					'region_lang.lang_id' => $langId,
				]);
			}
		]);
		return $this;
	}
}