<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "tour_type_lang".
 *
 * @property integer $id
 * @property integer $tour_type_id
 * @property integer $lang_id
 * @property string $name
 * @property string $description
 *
 * @property Lang $lang
 * @property TourType $tourType
 */
class TourTypeLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour_type_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tour_type_id', 'lang_id'], 'required'],
            [['tour_type_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tour_type_lang', 'ID'),
            'tour_type_id' => Yii::t('tour_type_lang', 'Tour Type ID'),
            'lang_id' => Yii::t('tour_type_lang', 'Lang ID'),
            'name' => Yii::t('tour_type_lang', 'Name'),
            'description' => Yii::t('tour_type_lang', 'Description'),
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
    public function getTourType()
    {
        return $this->hasOne(TourType::className(), ['id' => 'tour_type_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\TourTypeLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\TourTypeLangQuery(get_called_class());
    }
}
