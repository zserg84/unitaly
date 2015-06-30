<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 29.06.15
 * Time: 11:11
 */

namespace modules\base\components;


use modules\base\validators\LangRequiredValidator;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class ActiveField extends \yii\widgets\ActiveField
{

    public function begin()
    {
        if ($this->form->enableClientScript) {
            $clientOptions = $this->getClientOptions();
            if (!empty($clientOptions)) {
                $this->form->attributes[] = $clientOptions;
            }
        }

        $inputID = Html::getInputId($this->model, $this->attribute);
        $attribute = Html::getAttributeName($this->attribute);
        $options = $this->options;
        $class = isset($options['class']) ? [$options['class']] : [];
        $class[] = "field-$inputID";
        if ($this->model->isAttributeRequired($attribute)) {
            $class[] = $this->form->requiredCssClass;
        }

        if ($this->model->hasErrors($attribute)) {
            $class[] = $this->form->errorCssClass;
        }

        foreach ($this->model->getActiveValidators($attribute) as $validator) {
            if ($validator instanceof LangRequiredValidator && $validator->when === null) {
                $attr = $this->attribute;
                $langId = substr($attr, strpos($attr, '[')+1);
                $langId = substr($langId, 0, strpos($langId, ']'));
                foreach($validator->getLangs() as $lang){
                    if($lang->id==$langId)
                        $class[] = $this->form->requiredCssClass;
                }
            }
        }

        $options['class'] = implode(' ', $class);
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        return Html::beginTag($tag, $options);
    }
} 