<?php

namespace modules\directory\models;

use modules\directory\Module as DirectoryModule;
use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "shop".
 *
 * @property integer $id
 * @property integer $shop_type_id
 * @property integer $frontend
 * @property integer $city_id
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $phone
 * @property string $phone_additional
 * @property string $phone_additional_comment
 * @property string $fax
 * @property string $email
 * @property string $network
 * @property string $site
 * @property string $facebook
 * @property string $instagram
 * @property integer $logo_image_id
 * @property integer $main_image_id
 * @property integer $additional_image_id
 * @property integer $shop_category_id
 *
 * @property ShopCategory $shopCategory
 * @property ShopType $shopType
 * @property Image $additionalImage
 * @property City $city
 * @property Image $logoImage
 * @property Image $mainImage
 * @property ShopGoodCategory[] $shopGoodCategories
 * @property ShopLang[] $shopLangs
 * @property ShopSchedule[] $shopSchedules
 */
class Shop extends \yii\db\ActiveRecord
{
    public $name;
    public $spellings;
    public $worktime;
    public $description;
    public $short_description;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_type_id', 'city_id'], 'required'],
            [['shop_type_id', 'frontend', 'city_id', 'logo_image_id', 'main_image_id', 'additional_image_id', 'shop_category_id'], 'integer'],
            [['latitude', 'longitude', 'phone'], 'string', 'max' => 50],
            [['address', 'phone_additional', 'phone_additional_comment', 'fax', 'email', 'network', 'site', 'facebook', 'instagram'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('shop', 'ID'),
            'shop_type_id' => DirectoryModule::t('shop', 'SHOP_TYPE_ID'),
            'name' => DirectoryModule::t('shop', 'TRANSLATION_NAME'),
            'frontend' => DirectoryModule::t('shop', 'FRONTEND'),
            'city_id' => DirectoryModule::t('shop', 'CITY_ID'),
            'address' => DirectoryModule::t('shop', 'ADDRESS'),
            'latitude' => DirectoryModule::t('shop', 'LATITUDE'),
            'longitude' => DirectoryModule::t('shop', 'LONGITUDE'),
            'phone' => DirectoryModule::t('shop', 'PHONE'),
            'phone_additional' => DirectoryModule::t('shop', 'PHONE_ADDITIONAL'),
            'phone_additional_comment' => DirectoryModule::t('shop', 'PHONE_ADDITIONAL_COMMENT'),
            'fax' => DirectoryModule::t('shop', 'FAX'),
            'email' => DirectoryModule::t('shop', 'EMAIL'),
            'network' => DirectoryModule::t('shop', 'NETWORK'),
            'site' => DirectoryModule::t('shop', 'SITE'),
            'facebook' => DirectoryModule::t('shop', 'FACEBOOK'),
            'instagram' => DirectoryModule::t('shop', 'INSTAGRAM'),
            'logo_image_id' => DirectoryModule::t('shop', 'LOGO_IMAGE_ID'),
            'main_image_id' => DirectoryModule::t('shop', 'MAIN_IMAGE_ID'),
            'additional_image_id' => DirectoryModule::t('shop', 'ADDITIONAL_IMAGE_ID'),
            'shop_category_id' => DirectoryModule::t('shop', 'SHOP_CATEGORY_ID'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => ShopLang::className(),
                'relationFieldName' => 'shop_id',
                'translateFieldNames' => ['name', 'short_description', 'description', 'worktime'],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopCategory()
    {
        return $this->hasOne(ShopCategory::className(), ['id' => 'shop_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopType()
    {
        return $this->hasOne(ShopType::className(), ['id' => 'shop_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'additional_image_id']);
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
    public function getLogoImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'logo_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'main_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopGoodCategories()
    {
        return $this->hasMany(ShopGoodCategory::className(), ['shop_id' => 'id']);
    }

    /*
     * Сохраняем связанные категории товаров
     * $categories - массив [1,2,3], где 1,2,3 - айдишники категорий
     * */
    public function saveShopGoodCategories($categories)
    {
        $shopCategories = $this->getShopGoodCategories()->all();
        foreach($shopCategories as $shopCategory){
            if(!in_array($shopCategory->id, $categories))
                $this->unlink('shopGoodCategories', $shopCategory, true);
        }
        foreach($categories as $categoryId){
            $category = new ShopGoodCategory();
            $category->shop_id = $this->id;
            $category->good_category_id = $categoryId;
            $this->link('shopGoodCategories', $category);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopLangs()
    {
        return $this->hasMany(ShopLang::className(), ['shop_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopSchedules()
    {
        return $this->hasMany(ShopSchedule::className(), ['shop_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShopQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShopQuery(get_called_class());
    }
}
