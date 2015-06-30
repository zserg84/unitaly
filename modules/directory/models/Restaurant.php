<?php

namespace modules\directory\models;

use Yii;
use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use modules\translations\models\Lang;
use yii\helpers\ArrayHelper;
use modules\directory\models;
use modules\directory\Module as DirectoryModule;

/**
 * This is the model class for table "restaurant".
 *
 * @property integer $id
 * @property integer $frontend
 * @property string $name
 * @property string $spellings
 * @property string $rest_net
 * @property integer $stars
 * @property integer $region_id
 * @property integer $city_id
 * @property string $latitude
 * @property string $longitude
 * @property integer $logo_image_id
 * @property integer $menu_image_id
 * @property string $address
 * @property integer $hotel_id
 * @property string $worktime
 * @property string $main_phone
 * @property string $add_phone
 * @property string $site
 * @property string $facebook
 * @property string $instagram
 *
 * @property City $city
 * @property Hotel $hotel
 * @property Region $region
 * @property RestaurantLang[] $restaurantLangs
 */
class Restaurant extends \yii\db\ActiveRecord
{
    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => RestaurantLang::className(),
                'relationFieldName' => 'restaurant_id',
                'translateFieldNames' => ['name'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'restaurant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frontend', 'stars', 'region_id', 'city_id', 'logo_image_id', 'menu_image_id', 'hotel_id'], 'integer'],
            [['latitude', 'longitude', 'name', 'spellings', 'rest_net', 'address', 'worktime', 'main_phone', 'add_phone', 'site', 'facebook', 'instagram'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('restaurant', 'IDENTIFIER'),
            'frontend' => DirectoryModule::t('restaurant', 'FRONTEND'),
            'name' => DirectoryModule::t('restaurant', 'TRANSLATION_NAME'),
            'spellings' => DirectoryModule::t('restaurant', 'SPELLINGS'),
            'rest_net' => DirectoryModule::t('restaurant', 'REST_NET'),
            'stars' => DirectoryModule::t('restaurant', 'STARS'),
            'region_id' => DirectoryModule::t('restaurant', 'REGION_ID'),
            'city_id' => DirectoryModule::t('restaurant', 'CITY_ID'),
            'latitude' => DirectoryModule::t('restaurant', 'LATITUDE'),
            'longitude' => DirectoryModule::t('restaurant', 'LONGITUDE'),
            'logo_image_id' => DirectoryModule::t('restaurant', 'LOGO_IMAGE'),
            'menu_image_id' => DirectoryModule::t('restaurant', 'MENU_IMAGE'),
            'address' => DirectoryModule::t('restaurant', 'ADDRESS'),
            'hotel_id' => DirectoryModule::t('restaurant', 'HOTEL_ID'),
            'worktime' => DirectoryModule::t('restaurant', 'WORKTIME'),
            'main_phone' => DirectoryModule::t('restaurant', 'MAIN_PHONE'),
            'add_phone' => DirectoryModule::t('restaurant', 'ADD_PHONE'),
            'site' => DirectoryModule::t('restaurant', 'SITE'),
            'facebook' => DirectoryModule::t('restaurant', 'FACEBOOK'),
            'instagram' => DirectoryModule::t('restaurant', 'INSTAGRAM'),
        ];
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
    public function getHotel()
    {
        return $this->hasOne(Hotel::className(), ['id' => 'hotel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantLangs()
    {
        return $this->hasMany(RestaurantLang::className(), ['restaurant_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegionList()
    {
        $data = Region::find()->all();
        return ArrayHelper::map($data, 'id', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityList()
    {
        $query = City::find();
        $lang = Lang::getCurrent();
        $query->innerJoinWith([
            'cityLangs' => function($query) use($lang) {
                $query->from('city_lang as cl');
                $query->andWhere(['lang_id'=>$lang->id]);
            }
        ]);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = ArrayHelper::map($data, 'id', 'identifier');
        return $out;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelList()
    {
        //$data = Region::find()->all();
        //return ArrayHelper::map($data, 'id', 'name');
        return [];
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
    public function getMenuImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'menu_image_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\RestaurantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\RestaurantQuery(get_called_class());
    }
}
