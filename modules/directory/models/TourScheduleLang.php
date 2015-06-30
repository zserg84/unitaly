<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "tour_schedule_lang".
 *
 * @property integer $id
 * @property integer $tour_schedule_id
 * @property integer $lang_id
 * @property string $text
 *
 * @property Lang $lang
 * @property TourSchedule $tourSchedule
 */
class TourScheduleLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour_schedule_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tour_schedule_id', 'lang_id'], 'required'],
            [['tour_schedule_id', 'lang_id'], 'integer'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tour_schedule_lang', 'ID'),
            'tour_schedule_id' => Yii::t('tour_schedule_lang', 'Tour Schedule ID'),
            'lang_id' => Yii::t('tour_schedule_lang', 'Lang ID'),
            'text' => Yii::t('tour_schedule_lang', 'Text'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourSchedule()
    {
        return $this->hasOne(TourSchedule::className(), ['id' => 'tour_schedule_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\TourScheduleLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\TourScheduleLangQuery(get_called_class());
    }
}
