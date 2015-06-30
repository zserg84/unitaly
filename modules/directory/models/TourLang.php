<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "tour_lang".
 *
 * @property integer $id
 * @property integer $tour_id
 * @property integer $lang_id
 * @property string $name
 *
 * @property Lang $lang
 * @property Tour $tour
 */
class TourLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tour_id', 'lang_id'], 'required'],
            [['tour_id', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tour_lang', 'ID'),
            'tour_id' => Yii::t('tour_lang', 'Tour ID'),
            'lang_id' => Yii::t('tour_lang', 'Lang ID'),
            'name' => Yii::t('tour_lang', 'Name'),
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
    public function getTour()
    {
        return $this->hasOne(Tour::className(), ['id' => 'tour_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\TourLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\TourLangQuery(get_called_class());
    }
}
