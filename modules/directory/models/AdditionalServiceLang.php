<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "additional_service_lang".
 *
 * @property integer $id
 * @property integer $additional_service_id
 * @property string $name
 * @property integer $lang_id
 * @property string $description
 *
 * @property Lang $lang
 * @property AdditionalService $additionalService
 */
class AdditionalServiceLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'additional_service_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['additional_service_id', 'lang_id'], 'required'],
            [['additional_service_id', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
	        [['description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('additional_service_lang', 'ID'),
            'additional_service_id' => Yii::t('additional_service_lang', 'Additional Service ID'),
            'name' => Yii::t('additional_service_lang', 'Name'),
            'description' => Yii::t('additional_service_lang', 'Description'),
            'lang_id' => Yii::t('additional_service_lang', 'Lang ID'),
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
    public function getAdditionalService()
    {
        return $this->hasOne(AdditionalService::className(), ['id' => 'additional_service_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\AdditionalServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\AdditionalServiceQuery(get_called_class());
    }
}
