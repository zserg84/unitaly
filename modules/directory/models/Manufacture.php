<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use Yii;
use modules\directory\Module as DirectoryModule;
use yii\base\Exception;

/**
 * This is the model class for table "manufacture".
 *
 * @property integer $id
 * @property integer $frontend
 * @property string $legal_entity
 * @property string $network
 * @property string $associations
 * @property integer $manufacture_type_id
 * @property integer $image_id
 * @property integer $mediaface_image_id
 * @property string $mediaface_appeal
 * @property integer $city_id
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $phone
 * @property string $email
 * @property string $site
 * @property string $purchase_url
 * @property string $facebook
 * @property string $instagram
 * @property integer $restaurant_id
 * @property integer $shop_id
 * @property integer $showplace_id
 * @property integer $placement_id
 *
 * @property Placement $placement
 * @property City $city
 * @property Image $image
 * @property Image $mediafaceImage
 * @property Restaurant $restaurant
 * @property Shop $shop
 * @property Showplace $showplace
 * @property ManufactureType $manufactureType
 * @property ManufactureLang[] $manufactureLangs
 */
class Manufacture extends \yii\db\ActiveRecord
{
    const MANUFACTURE_RESTAURANT = 1;
    const MANUFACTURE_STORE = 2;
    const MANUFACTURE_SHOWPLACE = 3;
    const MANUFACTURE_PLACEMENT = 4;

    public $name;
    public $spellings;
    public $mediaface_name;
    public $worktime;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manufacture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frontend', 'manufacture_type_id', 'image_id', 'mediaface_image_id', 'city_id', 'restaurant_id', 'shop_id', 'showplace_id', 'placement_id'], 'integer'],
            [['manufacture_type_id'], 'required'],
            [['mediaface_appeal'], 'string'],
            [['legal_entity', 'network', 'associations', 'address', 'facebook', 'instagram'], 'string', 'max' => 255],
            [['latitude', 'longitude', 'phone', 'email', 'site', 'purchase_url'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('manufacture', 'IDENTIFIER'),
            'frontend' => DirectoryModule::t('manufacture', 'FRONTEND'),
            'legal_entity' => DirectoryModule::t('manufacture', 'LEGAL_ENTITY'),
            'network' => DirectoryModule::t('manufacture', 'NETWORK'),
            'associations' => DirectoryModule::t('manufacture', 'ASSOCIATIONS'),
            'manufacture_type_id' => DirectoryModule::t('manufacture', 'MANUFACTURE_TYPE_ID'),
            'image_id' => DirectoryModule::t('manufacture', 'IMAGE_ID'),
            'mediaface_image_id' => DirectoryModule::t('manufacture', 'MEDIAFACE_IMAGE_ID'),
            'mediaface_appeal' => DirectoryModule::t('manufacture', 'MEDIAFACE_APPEAL'),
            'city_id' => DirectoryModule::t('manufacture', 'CITY_ID'),
            'address' => DirectoryModule::t('manufacture', 'ADDRESS'),
            'latitude' => DirectoryModule::t('manufacture', 'LATITUDE'),
            'longitude' => DirectoryModule::t('manufacture', 'LONGITUDE'),
            'phone' => DirectoryModule::t('manufacture', 'PHONE'),
            'email' => DirectoryModule::t('manufacture', 'EMAIL'),
            'site' => DirectoryModule::t('manufacture', 'SITE'),
            'purchase_url' => DirectoryModule::t('manufacture', 'PURCHASE_URL'),
            'facebook' => DirectoryModule::t('manufacture', 'FACEBOOK'),
            'instagram' => DirectoryModule::t('manufacture', 'INSTAGRAM'),
            'restaurant_id' => DirectoryModule::t('manufacture', 'RESTAURANT_ID'),
            'shop_id' => DirectoryModule::t('manufacture', 'SHOP_ID'),
            'showplace_id' => DirectoryModule::t('manufacture', 'SHOWPLACE_ID'),
            'placement_id' => DirectoryModule::t('manufacture', 'PLACEMENT_ID'),
            'name' => DirectoryModule::t('manufacture', 'NAME'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => ManufactureLang::className(),
                'relationFieldName' => 'manufacture_id',
                'translateFieldNames' => ['name', 'spellings', 'worktime', 'mediaface_name'],
            ],
        ];
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
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
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
    public function getMediafaceImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'mediaface_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShowplace()
    {
        return $this->hasOne(Showplace::className(), ['id' => 'showplace_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufactureType()
    {
        return $this->hasOne(ManufactureType::className(), ['id' => 'manufacture_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufactureLangs()
    {
        return $this->hasMany(ManufactureLang::className(), ['manufacture_id' => 'id'])->indexBy('lang_id');
    }

    /*
     * Составляющие производства
     * */
    public static function componentsManufacture(){
        return [
            self::MANUFACTURE_RESTAURANT => DirectoryModule::t('manufacture', 'MANUFACTURE_RESTAURANT'),
            self::MANUFACTURE_RESTAURANT => DirectoryModule::t('manufacture', 'MANUFACTURE_STORE'),
            self::MANUFACTURE_RESTAURANT => DirectoryModule::t('manufacture', 'MANUFACTURE_SHOWPLACE'),
            self::MANUFACTURE_RESTAURANT => DirectoryModule::t('manufacture', 'MANUFACTURE_PLACEMENT'),
        ];
    }

    public static function getComponentManufacture($componentId){
        $components = self::componentsManufacture();
        if(!isset($components[$componentId]))
            throw new Exception('Unknown component');
        return $components[$componentId];
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ManufactureQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ManufactureQuery(get_called_class());
    }
}
