<?php

namespace modules\directory\models\query;
use modules\directory\models\ServiceCategory;

/**
 * This is the ActiveQuery class for [[\modules\directory\models\ServiceType]].
 *
 * @see \modules\directory\models\ServiceType
 */
class ServiceTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\directory\models\ServiceType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\ServiceType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /*
     * Опции туров
     * */
    public function tour(){
        $this->andWhere([
            'category_id' => ServiceCategory::CATEGORY_TOUR,
        ]);
        return $this;
    }

    /*
     * Опции отелей
     * */
    public function hotel(){
        $this->andWhere([
            'category_id' => ServiceCategory::CATEGORY_HOTEL,
        ]);
        return $this;
    }

    /*
     * Опции номеров
     * */
    public function room(){
        $this->andWhere([
            'category_id' => ServiceCategory::CATEGORY_ROOM,
        ]);
        return $this;
    }

    /*
     * Опции кафе
     * */
    public function cafe(){
        $this->andWhere([
            'category_id' => ServiceCategory::CATEGORY_CAFE,
        ]);
        return $this;
    }
}