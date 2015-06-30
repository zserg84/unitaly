<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "manufacture_type_lang".
 *
 * @property integer $id
 * @property integer $manufacture_type_id
 * @property integer $lang_id
 * @property string $name
 * @property string $description
 *
 * @property Lang $lang
 * @property ManufactureType $manufactureType
 */
class ManufactureTypeLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manufacture_type_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manufacture_type_id', 'lang_id'], 'required'],
            [['manufacture_type_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('manufacture_type_lang', 'ID'),
            'manufacture_type_id' => Yii::t('manufacture_type_lang', 'Manufacture Type ID'),
            'lang_id' => Yii::t('manufacture_type_lang', 'Lang ID'),
            'name' => Yii::t('manufacture_type_lang', 'Name'),
            'description' => Yii::t('manufacture_type_lang', 'Description'),
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
    public function getManufactureType()
    {
        return $this->hasOne(ManufactureType::className(), ['id' => 'manufacture_type_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ManufactureTypeLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ManufactureTypeLangQuery(get_called_class());
    }
}
