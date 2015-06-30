<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use modules\users\models\User;
use Yii;
use modules\directory\Module as DirectoryModule;

/**
 * This is the model class for table "tour".
 *
 * @property integer $id
 * @property integer $provider_id
 * @property integer $tour_type_id
 * @property string $name
 * @property integer $days_cnt
 * @property integer $nights_cnt
 * @property integer $city_id
 * @property integer $date_start
 * @property string $price
 * @property integer $food_type_id
 * @property string $short_description
 * @property string $description
 * @property string $seller_name
 * @property string $seller_phone
 * @property string $seller_email
 * @property integer $image_id
 * @property integer $additional_image_id
 * @property integer $tour_offer_type_id
 * @property integer $frontend
 *
 * @property Image $additionalImage
 * @property City $city
 * @property Image $image
 * @property Users $provider
 * @property TourOfferType $tourOfferType
 * @property TourType $tourType
 * @property TourLang[] $tourLangs
 * @property TourSchedule[] $tourSchedules
 * @property TourService[] $tourServices
 */
class Tour extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider_id', 'tour_type_id', 'city_id', 'date_start'/*, 'food_type_id'*/], 'required'],
            [['provider_id', 'tour_type_id', 'days_cnt', 'nights_cnt', 'city_id', 'food_type_id', 'image_id', 'additional_image_id', 'tour_offer_type_id', 'frontend'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['name', 'short_description', 'seller_name', 'seller_phone', 'seller_email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('tour', 'IDENTIFIER'),
            'provider_id' => DirectoryModule::t('tour', 'PROVIDER_ID'),
            'tour_type_id' => DirectoryModule::t('tour', 'TOUR_TYPE_ID'),
            'name' => DirectoryModule::t('tour', 'TRANSLATION_NAME'),
            'days_cnt' => DirectoryModule::t('tour', 'DAYS_CNT'),
            'nights_cnt' => DirectoryModule::t('tour', 'NIGHTS_CNT'),
            'region_id' => DirectoryModule::t('tour', 'REGION_ID'),
            'city_id' => DirectoryModule::t('tour', 'CITY_ID'),
            'date_start' => DirectoryModule::t('tour', 'DATE_START'),
            'price' => DirectoryModule::t('tour', 'PRICE'),
            'food_type_id' => DirectoryModule::t('tour', 'FOOD_TYPE_ID'),
            'short_description' => DirectoryModule::t('tour', 'SHORT_DESCRIPTION'),
            'description' => DirectoryModule::t('tour', 'DESCRIPTION'),
            'seller_name' => DirectoryModule::t('tour', 'SELLER_NAME'),
            'seller_phone' => DirectoryModule::t('tour', 'SELLER_PHONE'),
            'seller_email' => DirectoryModule::t('tour', 'SELLER_EMAIL'),
            'tour_offer_type_id' => DirectoryModule::t('tour', 'TOUR_OFFER_TYPE_ID'),
            'frontend' => DirectoryModule::t('tour', 'FRONTEND'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => TourLang::className(),
                'relationFieldName' => 'tour_id',
                'translateFieldNames' => ['name'],
            ],
        ];
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
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(User::className(), ['id' => 'provider_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourOfferType()
    {
        return $this->hasOne(TourOfferType::className(), ['id' => 'tour_offer_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourType()
    {
        return $this->hasOne(TourType::className(), ['id' => 'tour_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourLangs()
    {
        return $this->hasMany(TourLang::className(), ['tour_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourSchedules()
    {
        return $this->hasMany(TourSchedule::className(), ['tour_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourServices()
    {
        return $this->hasMany(TourService::className(), ['tour_id' => 'id']);
    }

    public function beforeSave($insert){
        $this->date_start = Yii::$app->getFormatter()->asTimestamp($this->date_start);
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\TourQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\TourQuery(get_called_class());
    }
}
