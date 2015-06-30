<?php

namespace modules\directory\models;

use modules\directory\Module as DirectoryModule;
use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use Yii;

/**
 * This is the model class for table "cafe".
 *
 * @property integer $id
 * @property integer $frontend
 * @property string $rest_net
 * @property integer $city_id
 * @property string $address
 * @property integer $placement_id
 * @property string $latitude
 * @property string $longitude
 * @property integer $logo_image_id
 * @property string $site
 * @property string $facebook
 * @property string $instagram
 *
 * @property Image $logoImage
 * @property City $city
 * @property Placement $placement
 * @property CafeLang[] $cafeLangs
 * @property CafeService[] $cafeServices
 */
class Cafe extends \yii\db\ActiveRecord
{
    public $name;
    public $spellings;
    public $worktime;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cafe';
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => CafeLang::className(),
                'relationFieldName' => 'cafe_id',
                'translateFieldNames' => ['name', 'spellings', 'worktime'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frontend', 'city_id', 'placement_id', 'logo_image_id'], 'integer'],
            [['rest_net', 'address', 'site', 'facebook', 'instagram'], 'string', 'max' => 255],
            [['latitude', 'longitude'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('cafe', 'IDENTIFIER'),
            'frontend' => DirectoryModule::t('cafe', 'FRONTEND'),
            'name' => DirectoryModule::t('cafe', 'TRANSLATION_NAME'),
            'spellings' => DirectoryModule::t('cafe', 'TRANSLATION_SPELLINGS'),
            'rest_net' => DirectoryModule::t('restaurant', 'REST_NET'),
            'region_id' => DirectoryModule::t('cafe', 'REGION_ID'),
            'province_id' => DirectoryModule::t('cafe', 'PROVINCE_ID'),
            'city_id' => DirectoryModule::t('cafe', 'CITY_ID'),
            'latitude' => DirectoryModule::t('cafe', 'LATITUDE'),
            'longitude' => DirectoryModule::t('cafe', 'LONGITUDE'),
            'logo_image' => DirectoryModule::t('cafe', 'LOGO_IMAGE'),
            'address' => DirectoryModule::t('cafe', 'ADDRESS'),
            'placement_id' => DirectoryModule::t('cafe', 'PLACEMENT_ID'),
            'worktime' => DirectoryModule::t('cafe', 'TRANSLATION_WORKTIME'),
            'site' => DirectoryModule::t('cafe', 'SITE'),
            'facebook' => DirectoryModule::t('cafe', 'FACEBOOK'),
            'instagram' => DirectoryModule::t('cafe', 'INSTAGRAM'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogoImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'logo_image_id']);
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
    public function getPlacement()
    {
        return $this->hasOne(Placement::className(), ['id' => 'placement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCafeLangs()
    {
        return $this->hasMany(CafeLang::className(), ['cafe_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCafeServices()
    {
        return $this->hasMany(CafeService::className(), ['cafe_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\CafeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\CafeQuery(get_called_class());
    }
}
