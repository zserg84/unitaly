<?php

namespace modules\directory\models;

use Yii;
use modules\base\behaviors\LangSaveBehavior;
use modules\image\models\Image;
use modules\base\behaviors\TranslateBehavior;
use modules\directory\Module as DirectoryModule;

/**
 * This is the model class for table "hub".
 *
 * @property integer $id
 * @property string $name
 * @property integer $image_id
 * @property integer $city_id
 * @property string $airport
 * @property string $port
 * @property string $code_iata
 * @property string $code_icao
 * @property string $arrival_table
 * @property string $departure_table
 * @property string $description
 *
 * @property City[] $cities
 * @property Image $image
 * @property City $city
 * @property HubLang[] $hubLangs
 */
class Hub extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hub';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id'], 'required'],
            [['image_id', 'city_id'], 'integer'],
	        [['description'], 'string'],
            [['name', 'airport', 'port', 'code_iata', 'code_icao', 'arrival_table', 'departure_table'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		return [
			'id' => DirectoryModule::t('hub', 'ID'),
			'name' => DirectoryModule::t('hub', 'NAME'),
			'spellings' => DirectoryModule::t('hub', 'SPELLINGS'),
			'region_id' => DirectoryModule::t('hub', 'REGION_ID'),
			'province_id' => DirectoryModule::t('hub', 'PROVINCE_ID'),
			'city_id' => DirectoryModule::t('hub', 'CITY_ID'),
			'cityName' => DirectoryModule::t('hub', 'CITY_ID'),
			'image' => DirectoryModule::t('hub', 'IMAGE'),
			'airport' => DirectoryModule::t('hub', 'AIRPORT'),
			'port' => DirectoryModule::t('hub', 'PORT'),
			'description' => DirectoryModule::t('hub', 'DESCRIPTION'),
			'code_iata' => DirectoryModule::t('hub', 'CODE_IATA'),
			'code_icao' => DirectoryModule::t('hub', 'CODE_ICAO'),
			'arrival_table' => DirectoryModule::t('hub', 'ARRIVAL_TABLE'),
			'departure_table' => DirectoryModule::t('hub', 'DEPARTURE_TABLE'),
			'description' => DirectoryModule::t('hub', 'DESCRIPTION'),
		];
	}

	public function behaviors(){
		return [
			'langSave' => [
				'class' => LangSaveBehavior::className(),
			],
			'translate' => [
				'class' => TranslateBehavior::className(),
				'translateModelName' => HubLang::className(),
				'relationFieldName' => 'hub_id',
				'translateFieldNames' => ['name', 'description'],
			],
		];
	}

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['hub_id' => 'id']);
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
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHubLangs()
    {
        return $this->hasMany(HubLang::className(), ['hub_id' => 'id'])->indexBy('lang_id');
    }

	/**
     * @inheritdoc
     * @return \modules\directory\models\query\HubQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\HubQuery(get_called_class());
    }
}
