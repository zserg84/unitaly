<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 15.06.15
 * Time: 14:44
 */

namespace modules\directory\models\form;

use modules\directory\Module as DirectoryModule;
use yii\base\Model;

class TourScheduleForm extends Model
{

    public $date;
    public $time_from;
    public $time_to;
    public $text;
    public $tourId;
    public $translationText;

    public function rules()
    {
        return [
            [['text', 'date', 'time_from'], 'required'],
            [['date'], 'integer'],
            [['text'], 'string'],
            [['time_from', 'time_to', 'date', 'text'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text' => DirectoryModule::t('tour-schedule', 'TEXT'),
            'date' => DirectoryModule::t('tour-schedule', 'DATE'),
            'time_from' => DirectoryModule::t('tour-schedule', 'TIME_FROM'),
            'time_to' => DirectoryModule::t('tour-schedule', 'TIME_TO'),
        ];
    }
} 