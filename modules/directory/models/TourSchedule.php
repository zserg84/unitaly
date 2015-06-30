<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use Yii;

/**
 * This is the model class for table "tour_schedule".
 *
 * @property integer $id
 * @property integer $tour_id
 * @property string $text
 * @property integer $date
 * @property string $time_from
 * @property string $time_to
 *
 * @property Tour $tour
 * @property TourScheduleLang[] $tourScheduleLangs
 */
class TourSchedule extends \yii\db\ActiveRecord
{

    public static $langUrl = 'ru';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tour_id', 'text', 'date', 'time_from'], 'required'],
            [['tour_id', 'date'], 'integer'],
            [['text', 'time_from', 'time_to'], 'string'],
            [['time_from', 'time_to'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tour_schedule', 'ID'),
            'tour_id' => Yii::t('tour_schedule', 'Tour ID'),
            'text' => Yii::t('tour_schedule', 'Text'),
            'date' => Yii::t('tour_schedule', 'Date'),
            'time_from' => Yii::t('tour_schedule', 'Time From'),
            'time_to' => Yii::t('tour_schedule', 'Time To'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => TourScheduleLang::className(),
                'relationFieldName' => 'tour_schedule_id',
                'translateFieldNames' => ['text'],
                'langUrl' => self::$langUrl,
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTour()
    {
        return $this->hasOne(Tour::className(), ['id' => 'tour_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourScheduleLangs()
    {
        return $this->hasMany(TourScheduleLang::className(), ['tour_schedule_id' => 'id'])->indexBy('lang_id');
    }


    /**
     * @inheritdoc
     * @return \modules\directory\models\query\TourScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\TourScheduleQuery(get_called_class());
    }
}
