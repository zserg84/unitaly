<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 29.06.15
 * Time: 12:28
 */

namespace modules\base\components;


class ActiveForm extends \yii\bootstrap\ActiveForm
{

    public $fieldClass = null;

    public function init(){
        $this->fieldClass = $this->fieldClass ? $this->fieldClass : ActiveField::className();
        parent::init();
    }
} 