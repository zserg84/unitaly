<?php

namespace modules\base\validators;


use modules\directory\models\AdditionalService;
use modules\translations\models\Lang;
use yii\validators\Validator;

/*
 * проверяет уникальность ввода для опций
 * */
class OptionsUniqueValidator extends Validator
{
	/**
	 * @param \modules\directory\models\AdditionalService $model
	 * @param string $attribute
	 */
    public function validateAttribute($model, $attribute)
    {
	    $langs = Lang::find()->all();
        foreach($langs as $lang){
	        $langAttr = $attribute.'['.$lang->id.']';
            $attributes = $model->$attribute;
            $langAttrValue = isset($attributes[$lang->id]) ? $attributes[$lang->id] : null;
            if($langAttrValue) {
	            $name = strtolower(str_replace('translation', '', $attribute));
	            $val = $model->$attribute;
	            $exist = AdditionalService::find()->innerJoinWith('additionalServiceLangs')
		            ->andFilterWhere(['additional_service_lang.' . $name => $val[$lang->id]])
		            ->andFilterWhere(['additional_service_lang.lang_id' => $lang->id])
		            ->andFilterWhere(['additional_service.service_type_id' => $model->service_type_id])
		            ->andFilterWhere(['!=', 'additional_service.id', $model->id])
		            ->all()
	            ;
	            if ($exist) {
		            $model->addError($langAttr, $this->message);
	            }
            }
        }
    }
} 