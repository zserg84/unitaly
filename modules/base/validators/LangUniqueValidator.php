<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 17.06.15
 * Time: 17:52
 */

namespace modules\base\validators;


use yii\helpers\VarDumper;
use yii\validators\Validator;

/*
 * Валидатор уникальности поля для соответствующего языка
 * */
class LangUniqueValidator extends Validator
{

    public $filter;

    public $targetClass;

    public $targetAttribute;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = \Yii::t('yii', '{attribute} "{value}" has already been taken.');
        }
    }

    public function validateAttribute($model, $attribute){
        $targetClass = $this->targetClass === null ? get_class($model) : $this->targetClass;
        $targetAttribute = $this->targetAttribute === null ? $attribute : $this->targetAttribute;
        $targetTableName = $targetClass::tableName();
        $targetAttribute = $targetTableName . '.' .$targetAttribute;


        $attributes = $model->$attribute;
        foreach($attributes as $k=>$attr){
	        $query = $targetClass::find();
	        $query->from($targetTableName);
	        if ($this->filter instanceof \Closure) {
		        call_user_func($this->filter, $query);
	        } elseif ($this->filter !== null) {
		        $query->andWhere($this->filter);
	        }
            if(!$attr)
                continue;

            $query->andWhere([
                'lang_id' => $k,
                $targetAttribute => $attr,
            ]);

            $count = $query->count();
            if($count) {
                $params['attribute'] = $model->getAttributeLabel($attribute);
                $params['value'] = $attr;
                $model->addError($attribute . '[' . $k . ']', \Yii::$app->getI18n()->format($this->message, $params, \Yii::$app->language));
            }
        }
    }
} 