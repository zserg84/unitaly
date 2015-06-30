<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 09.06.15
 * Time: 11:46
 */

namespace modules\base\validators;

use yii\validators\RegularExpressionValidator;

class RusValidator extends RegularExpressionValidator
{

    public $pattern = '(?=.*?[а-Я])';
} 