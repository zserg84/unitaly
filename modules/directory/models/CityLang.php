<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "city_lang".
 *
 * @property integer $id
 * @property integer $city_id
 * @property integer $lang_id
 * @property string $name
 * @property string $description
 * @property string $history
 * @property string $spellings
 *
 * @property Lang $lang
 * @property City $city
 */
class CityLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'lang_id'], 'required'],
            [['city_id', 'lang_id'], 'integer'],
            [['description', 'history', 'spellings'], 'string'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'history' => Yii::t('app', 'History'),
            'spellings' => Yii::t('app', 'Spellings'),
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
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\CityLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\CityLangQuery(get_called_class());
    }
}
