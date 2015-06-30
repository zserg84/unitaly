<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\image\models\Image;
use modules\translations\models\Lang;
use Yii;
use modules\base\behaviors\TranslateBehavior;
use yii\base\Model;
use yii\helpers\VarDumper;
use modules\directory\Module as DirectoryModule;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $name
 * @property string $spellings
 * @property integer $visit_image_id
 * @property integer $arms_image_id
 * @property string $description
 * @property string $latitude
 * @property string $longitude
 * @property integer $hub_id
 * @property string $history
 * @property integer $province_id
 *
 * @property Cafe[] $caves
 * @property Province $province
 * @property Image $armsImage
 * @property Hub $hub
 * @property Image $visitImage
 * @property CityLang[] $cityLangs
 * @property Hub[] $hubs
 * @property Placement[] $placements
 * @property Province[] $provinces
 * @property Restaurant[] $restaurants
 * @property Showplace[] $showplaces
 * @property Tour[] $tours
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id'], 'required'],
            [['spellings', 'description', 'history'], 'string'],
            [['province_id', 'visit_image_id', 'arms_image_id', 'hub_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
	        [['latitude', 'longitude'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('city', 'ID'),
            'name' => DirectoryModule::t('city', 'NAME'),
            'spellings' => DirectoryModule::t('city', 'SPELLINGS'),
            'province_id' => DirectoryModule::t('city', 'PROVINCE_ID'),
            'visit_image_id' => DirectoryModule::t('city', 'VISIT_IMAGE_ID'),
            'arms_image_id' => DirectoryModule::t('city', 'ARMS_IMAGE_ID'),
            'description' => DirectoryModule::t('city', 'DESCRIPTION'),
            'latitude' => DirectoryModule::t('city', 'LATITUDE'),
            'longitude' => DirectoryModule::t('city', 'LONGITUDE'),
            'hub_id' => DirectoryModule::t('city', 'HUB_ID'),
            'history' => DirectoryModule::t('city', 'HISTORY'),
        ];
    }

	public function behaviors(){
		return [
			'langSave' => [
				'class' => LangSaveBehavior::className(),
			],
			'translate' => [
				'class' => TranslateBehavior::className(),
				'translateModelName' => CityLang::className(),
				'relationFieldName' => 'city_id',
				'translateFieldNames' => ['name', 'description', 'history', 'spellings'],
			],
		];
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaves()
    {
        return $this->hasMany(Cafe::className(), ['city_id' => 'id']);
    }

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getHub()
    {
        return $this->hasOne(Hub::className(), ['id' => 'hub_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArmsImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'arms_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinces()
    {
        return $this->hasMany(Province::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'visit_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurants()
    {
        return $this->hasMany(Restaurant::className(), ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShowplaces()
    {
        return $this->hasMany(Showplace::className(), ['city_id' => 'id']);
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCityLangs()
	{
		return $this->hasMany(CityLang::className(), ['city_id' => 'id'])->indexBy('lang_id');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getHubs()
	{
		return $this->hasMany(Hub::className(), ['city_id' => 'id']);
	}

	/**
     * @inheritdoc
     * @return \modules\directory\models\query\CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\CityQuery(get_called_class());
    }
}
