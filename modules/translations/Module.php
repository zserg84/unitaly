<?php

namespace modules\translations;

use modules\translations\components\DbMessageSource;
use Yii;
use yii\i18n\MissingTranslationEvent;
use modules\translations\models\SourceMessage;

class Module extends \modules\base\Module
{
    public $pageSize = 50;

    public static $name = 'translations';

    public static $langNames = ['translations', 'lang'];

    /**
     * @param MissingTranslationEvent $event
     */
    public static function missingTranslation(MissingTranslationEvent $event)
    {
        $driver = Yii::$app->getDb()->getDriverName();
        $caseInsensitivePrefix = $driver == 'mysql' ? 'binary' : '';
        $sourceMessage = SourceMessage::find()->innerJoinWith([
            'category' => function($query) use($event){
                $query->where([
                    'name' => $event->category
                ]);
            }
        ])->where('message = ' . $caseInsensitivePrefix . ' :message', [
            ':message' => $event->message
        ])
        ->with('messages')
        ->one();

        if (!$sourceMessage) {
            return;
//            $sourceMessage = new SourceMessage;
//            $sourceMessage->setAttributes([
//                'category_id' => $event->category,
//                'message' => $event->message
//            ], false);
//            $sourceMessage->save(false);
        }
        $sourceMessage->initMessages();
        $sourceMessage->saveMessages();
    }
}
