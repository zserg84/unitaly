<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 01.06.15
 * Time: 14:47
 */

namespace modules\base;

use modules\translations\components\DbMessageSource;
use modules\translations\models\Lang;
use yii\helpers\VarDumper;

class Module extends \vova07\base\components\Module
{

    /**
     * @var string Module author
     */
    public static $author = 'modules';

    public static $name = 'base';

    /**
     * @var array. Массив со ссылками на переводы (например, [static::$name, static::$name . 'lang'])
     * */
    public static $langNames = [];

    public function init()
    {
        static::initLang();
        parent::init();
    }

    public static function initLang(){
        $app = \Yii::$app;
        static::$langNames = static::$langNames ? static::$langNames : [static::$name, static::$name . '_lang'];
        foreach(static::$langNames as $langName){
            if (!isset($app->i18n->translations[$langName])) {
                $app->i18n->translations[$langName] = [
                    'class' => DbMessageSource::className(),
                    'forceTranslation' => true,
                ];
            }
        }
//        VarDumper::dump($app->i18n->translations,10,1);
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        static::initLang();
        $language = $language ? $language : Lang::getCurrent()->local;
        return \Yii::t($category, $message, $params, $language);
    }

    /*
     * язык страны, для которой пишется система.(не путать с sourceLanguage)
     * */
    public static function getSystemLanguage(){
        if(isset(\Yii::$app->params['systemLanguage']))
            $systemLanguage = \Yii::$app->params['systemLanguage'];
        else
            $systemLanguage = 'it';
        return $systemLanguage;
    }

} 