<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "manufacture_lang".
 *
 * @property integer $id
 * @property integer $manufacture_id
 * @property integer $lang_id
 * @property string $name
 * @property string $spellings
 * @property string $mediaface_name
 * @property string $worktime
 *
 * @property Lang $lang
 * @property Manufacture $manufacture
 */
class ManufactureLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manufacture_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manufacture_id', 'lang_id'], 'required'],
            [['manufacture_id', 'lang_id'], 'integer'],
            [['spellings'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['mediaface_name'], 'string', 'max' => 255],
            [['worktime'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('manufacture_lang', 'ID'),
            'manufacture_id' => Yii::t('manufacture_lang', 'Manufacture ID'),
            'lang_id' => Yii::t('manufacture_lang', 'Lang ID'),
            'name' => Yii::t('manufacture_lang', 'Name'),
            'spellings' => Yii::t('manufacture_lang', 'Spellings'),
            'mediaface_name' => Yii::t('manufacture_lang', 'Mediaface Name'),
            'worktime' => Yii::t('manufacture_lang', 'Worktime'),
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
    public function getManufacture()
    {
        return $this->hasOne(Manufacture::className(), ['id' => 'manufacture_id']);
    }
}
