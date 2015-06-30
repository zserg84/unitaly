<?php

namespace modules\directory\models\form;

use Yii;
use modules\base\behaviors\ImageBehavior;
use modules\image\models\Image;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use modules\directory\models\Restaurant;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\RestaurantLang;


class RestaurantForm extends Model
{
    public $id;
    public $name;
    public $worktime;
    public $logoImage;
    public $menuImage;
    public $frontend;
    public $translationName = [];
    public $spellings;
    public $rest_net;
    public $stars;
    public $region_id;
    public $city_id;
    public $latitude;
    public $longitude;
    public $logo_image;
    public $menu_image;
    public $logo_image_id;
    public $menu_image_id;
    public $address;
    public $hotel_id;
    public $translationWorktime = [];
    public $main_phone;
    public $add_phone;
    public $site;
    public $facebook;
    public $instagram;
    public $restaurant_type_id;
    public $province_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spellings', 'rest_net', 'region_id', 'address'], 'required'],
            [['frontend', 'stars', 'region_id', 'hotel_id', 'id'], 'integer'],
            [['latitude', 'longitude', 'name', 'spellings', 'rest_net', 'address', 'worktime', 'main_phone', 'add_phone', 'site', 'facebook', 'instagram'], 'string', 'max' => 255],
            [['logoImage', 'menuImage'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('themes-admin', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['translationName', LangRequiredValidator::className()],
            ['translationName', LangUniqueValidator::className(), 
                'targetClass' => RestaurantLang::className(), 'targetAttribute' => 'name', 'filter' => function($query){
                    $query->andWhere([
                        'restaurant_type_id' => $this->restaurant_type_id,
                    ]);
                    $query->innerJoinWith([
                        'restaurant' => function($query){
                            $query->andWhere(['<>', 'restaurant.id', $this->id]);
                        }
                    ]);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'frontend' => DirectoryModule::t('restaurant', 'FRONTEND'),
            'translationName' => DirectoryModule::t('restaurant', 'TRANSLATION_NAME'),
            'spellings' => DirectoryModule::t('restaurant', 'SPELLINGS'),
            'rest_net' => DirectoryModule::t('restaurant', 'REST_NET'),
            'restaurant_type_id' => DirectoryModule::t('restaurant', 'RESTAURANT_TYPE'),
            'stars' => DirectoryModule::t('restaurant', 'STARS'),
            'region_id' => DirectoryModule::t('restaurant', 'REGION_ID'),
            'city_id' => DirectoryModule::t('restaurant', 'CITY_ID'),
            'latitude' => DirectoryModule::t('restaurant', 'LATITUDE'),
            'longitude' => DirectoryModule::t('restaurant', 'LONGITUDE'),
            'logo_image' => DirectoryModule::t('restaurant', 'LOGO_IMAGE'),
            'menu_image' => DirectoryModule::t('restaurant', 'MENU_IMAGE'),
            'address' => DirectoryModule::t('restaurant', 'ADDRESS'),
            'hotel_id' => DirectoryModule::t('restaurant', 'HOTEL_ID'),
            'translationWorktime' => DirectoryModule::t('restaurant', 'WORKTIME'),
            'main_phone' => DirectoryModule::t('restaurant', 'MAIN_PHONE'),
            'add_phone' => DirectoryModule::t('restaurant', 'ADD_PHONE'),
            'site' => DirectoryModule::t('restaurant', 'SITE'),
            'facebook' => DirectoryModule::t('restaurant', 'FACEBOOK'),
            'instagram' => DirectoryModule::t('restaurant', 'INSTAGRAM'),
            'province_id' => DirectoryModule::t('province', 'IDENTIFIER')
        ];
    }

    public function behaviors()
    {
        return [
            'imageBehavior' => [
                'class' => ImageBehavior::className(),
            ]
        ];
    }

}
