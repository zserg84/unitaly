<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "cafe_lang".
 *
 * @property integer $id
 * @property integer $cafe_id
 * @property integer $lang_id
 * @property string $name
 * @property string $spellings
 * @property string $worktime
 *
 * @property Lang $lang
 * @property Cafe $cafe
 */
class CafeLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cafe_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cafe_id', 'lang_id'], 'required'],
            [['cafe_id', 'lang_id'], 'integer'],
            [['spellings', 'worktime'], 'string'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cafe_lang', 'ID'),
            'cafe_id' => Yii::t('cafe_lang', 'Cafe ID'),
            'lang_id' => Yii::t('cafe_lang', 'Lang ID'),
            'name' => Yii::t('cafe_lang', 'Name'),
            'spellings' => Yii::t('cafe_lang', 'Spellings'),
            'worktime' => Yii::t('cafe_lang', 'Worktime'),
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
    public function getCafe()
    {
        return $this->hasOne(Cafe::className(), ['id' => 'cafe_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\CafeLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\CafeLangQuery(get_called_class());
    }
}
