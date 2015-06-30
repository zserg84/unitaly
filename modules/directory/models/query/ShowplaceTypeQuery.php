<?php

namespace modules\directory\models\query;
use modules\translations\models\Lang;

/**
 * This is the ActiveQuery class for [[\modules\rbac\models\ShowplaceType]].
 *
 * @see \modules\rbac\models\ShowplaceType
 */
class ShowplaceTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \modules\rbac\models\ShowplaceType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \modules\rbac\models\ShowplaceType|array|null
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
            'showplaceTypeLangs' => function($query) use($langId){
                $query->where([
                    'showplace_type_lang.lang_id' => $langId,
                ]);
            }
        ]);
        return $this;
    }
}