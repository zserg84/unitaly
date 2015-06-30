<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\image\models\Image;
use Yii;
use modules\base\behaviors\TranslateBehavior;
use modules\directory\Module as DirectoryModule;

/**
 * This is the model class for table "region".
 *
 * @property integer $id
 * @property string $name
 * @property string $spellings
 * @property integer $visit_image_id
 * @property integer $flag_image_id
 * @property integer $arms_image_id
 * @property integer $city_id
 * @property string $description
 *
 * @property Province[] $provinces
 * @property Image $armsImage
 * @property City $city
 * @property Image $flagImage
 * @property Image $visitImage
 * @property RegionLang[] $regionLangs
 * @property Restaurant[] $restaurants
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spellings', 'description'], 'string'],
            [['visit_image_id', 'flag_image_id', 'arms_image_id', 'city_id'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('region', 'ID'),
            'name' => DirectoryModule::t('region', 'NAME'),
            'spellings' => DirectoryModule::t('region', 'SPELLINGS'),
            'visit_image_id' => DirectoryModule::t('region', 'VISIT_IMAGE_ID'),
            'flag_image_id' => DirectoryModule::t('region', 'FLAG_IMAGE_ID'),
            'arms_image_id' => DirectoryModule::t('region', 'ARMS_IMAGE_ID'),
            'city_id' => DirectoryModule::t('region', 'CITY_ID'),
            'description' => DirectoryModule::t('region', 'DESCRIPTION'),
        ];
    }

	public function behaviors(){
		return [
			'langSave' => [
				'class' => LangSaveBehavior::className(),
			],
			'translate' => [
				'class' => TranslateBehavior::className(),
				'translateModelName' => RegionLang::className(),
				'relationFieldName' => 'region_id',
				'translateFieldNames' => ['name', 'description', 'spellings'],
			],
		];
	}

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinces()
    {
        return $this->hasMany(Province::className(), ['region_id' => 'id']);
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
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
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
    public function getFlagImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'flag_image_id']);
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRegionLangs()
	{
		return $this->hasMany(RegionLang::className(), ['region_id' => 'id'])->indexBy('lang_id');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRestaurants()
	{
		return $this->hasMany(Restaurant::className(), ['region_id' => 'id']);
	}

	public static function find()
    {
        return new \modules\directory\models\query\RegionQuery(get_called_class());
    }
}
