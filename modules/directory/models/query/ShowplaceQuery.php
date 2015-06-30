<?php

namespace modules\directory\models\query;
use modules\translations\models\Lang;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\Showplace]].
 *
 * @see \modules\directory\models\Showplace
 */
class ShowplaceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\Showplace[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\Showplace|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

	/**
	 * условие ключевой достопримечательности
	 * @param null|boolean $key
	 *
	 * @return $this
	 */
	public function main($main = null){
		if (!is_null($main)) {
			$this->andWhere(($main) ? 'main' : '!main');
		}
		return $this;
	}

	public function city($city){
		$this->andWhere('city_id=:city', ['city' => $city]);
		return $this;
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
            'showplaceLangs' => function($query) use($langId){
                $query->where([
                    'showplace_lang.lang_id' => $langId,
                ]);
            }
        ]);
        return $this;
    }
}