<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use Yii;
use modules\directory\Module as DirectoryModule;

/**
 * This is the model class for table "additional_service".
 *
 * @property integer $id
 * @property string $name
 * @property integer $service_type_id
 * @property integer $image_id
 * @property string $description
 *
 * @property Image $image
 * @property ServiceType $serviceType
 * @property AdditionalServiceLang[] $additionalServiceLangs
 * @property CafeService[] $cafeServices
 * @property TourService[] $tourServices
 */
class AdditionalService extends \yii\db\ActiveRecord
{
	public $messageFileName = 'additional_service';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'additional_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_type_id'], 'required'],
            [['service_type_id', 'image_id'], 'integer'],
	        [['description'], 'string'],
	        [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t($this->messageFileName, 'ID'),
            'name' => DirectoryModule::t($this->messageFileName, 'Name'),
            'service_type_id' => DirectoryModule::t($this->messageFileName, 'Service Type ID'),
            'image_id' => DirectoryModule::t($this->messageFileName, 'Image ID'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => AdditionalServiceLang::className(),
                'relationFieldName' => 'additional_service_id',
                'translateFieldNames' => ['name', 'description'],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceType()
    {
        return $this->hasOne(ServiceType::className(), ['id' => 'service_type_id']);
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getImage()
	{
		return $this->hasOne(Image::className(), ['id' => 'image_id']);
	}

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalServiceLangs()
    {
        return $this->hasMany(AdditionalServiceLang::className(), ['additional_service_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCafeServices()
    {
        return $this->hasMany(CafeService::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourServices()
    {
        return $this->hasMany(TourService::className(), ['service_id' => 'id']);
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
