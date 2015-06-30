<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "province_lang".
 *
 * @property integer $id
 * @property integer $province_id
 * @property integer $lang_id
 * @property string $name
 * @property string $spellings
 * @property string $description
 *
 * @property Lang $lang
 * @property Province $province
 */
class ProvinceLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'province_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id', 'lang_id'], 'required'],
            [['province_id', 'lang_id'], 'integer'],
            [['spellings', 'description'], 'string'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('province_lang', 'ID'),
            'province_id' => Yii::t('province_lang', 'Province ID'),
            'lang_id' => Yii::t('province_lang', 'Lang ID'),
            'name' => Yii::t('province_lang', 'Name'),
            'spellings' => Yii::t('province_lang', 'Spellings'),
            'description' => Yii::t('province_lang', 'Description'),
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
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ProvinceLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ProvinceLangQuery(get_called_class());
    }
}
