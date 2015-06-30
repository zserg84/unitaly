<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "region_lang".
 *
 * @property integer $id
 * @property integer $region_id
 * @property integer $lang_id
 * @property string $name
 * @property string $description
 * @property string $spellings
 *
 * @property Lang $lang
 * @property Region $region
 */
class RegionLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'lang_id'], 'required'],
            [['region_id', 'lang_id'], 'integer'],
            [['description', 'spellings'], 'string'],
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
            'region_id' => Yii::t('app', 'Region ID'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
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
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\RegionLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\RegionLangQuery(get_called_class());
    }
}
