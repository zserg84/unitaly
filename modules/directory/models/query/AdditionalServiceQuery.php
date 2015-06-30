<?php

namespace modules\directory\models\query;
use modules\directory\models\ServiceType;
use modules\translations\models\Lang;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\AdditionalServiceLang]].
 *
 * @see \modules\directory\models\AdditionalServiceLang
 */
class AdditionalServiceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\AdditionalServiceLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\AdditionalServiceLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /*
     * Опции туров
     * */
    public function tour(){
        return $this->innerJoinWith([
            'serviceType' => function($query){
                $query->tour();
            }
        ]);
    }

    /*
     * Опции отелей
     * */
    public function hotel(){
        return $this->innerJoinWith([
            'serviceType' => function($query){
                $query->hotel();
            }
        ]);
    }

    /*
     * Опции номеров
     * */
    public function room(){
        return $this->innerJoinWith([
            'serviceType' => function($query){
                $query->room();
            }
        ]);
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
			'additionalServiceLangs' => function($query) use($langId){
				$query->where([
					'lang_id' => $langId,
				]);
			}
		]);
		return $this;
	}
}