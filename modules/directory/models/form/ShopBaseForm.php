<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 24.06.15
 * Time: 16:14
 */

namespace modules\directory\models\form;

use modules\base\behaviors\ImageBehavior;
use modules\themes\Module as ThemeModule;
use modules\directory\Module as DirectoryModule;
use yii\base\Model;

class ShopBaseForm extends Model
{
    public $shop_type_id;
    public $frontend;
    public $translationName = [];
    public $translationSpellings = [];
    public $region_id;
    public $province_id;
    public $city_id;
    public $address = [];
    public $latitude;
    public $longitude;
    public $translationWorktime = [];
    public $phone;
    public $phone_additional;
    public $phone_additional_comment;
    public $fax;
    public $email;
    public $network;
    public $categories;
    public $site;
    public $facebook;
    public $instagram;
    public $translationShortDescription = [];
    public $translationDescription = [];
    public $logo_image;
    public $main_image;
    public $additional_image;

    public function rules()
    {
        return [
            [['region_id', 'province_id', 'city_id', 'shop_type_id'], 'integer'],
            [['logo_image', 'main_image', 'additional_image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>ThemeModule::t('themes-admin', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            [['email'], 'email'],
            [['translationShortDescription', 'translationDescription', 'translationName' ,'translationWorktime', 'translationSpellings', 'site', 'facebook', 'instagram', 'categories', 'network',
                'fax', 'phone', 'phone_additional', 'phone_additional_comment', 'frontend'], 'safe'],
	        [['shop_type_id'], 'required'],
        ];
    }

    public function attributeLabels(){
        return [
            'id' => DirectoryModule::t('shop', 'IDENTIFIER'),
            'frontend' => DirectoryModule::t('shop', 'FRONTEND'),
            'translationName' => DirectoryModule::t('shop', 'TRANSLATION_NAME'),
            'translationSpellings' => DirectoryModule::t('shop', 'TRANSLATION_SPELLINGS'),
            'region_id' => DirectoryModule::t('shop', 'REGION_ID'),
            'province_id' => DirectoryModule::t('shop', 'PROVINCE_ID'),
            'city_id' => DirectoryModule::t('shop', 'CITY_ID'),
            'address' => DirectoryModule::t('shop', 'ADDRESS'),
            'latitude' => DirectoryModule::t('shop', 'LATITUDE'),
            'longitude' => DirectoryModule::t('shop', 'LONGITUDE'),
            'translationWorktime' => DirectoryModule::t('shop', 'TRANSLATION_WORKTIME'),
            'phone' => DirectoryModule::t('shop', 'PHONE'),
            'phone_additional' => DirectoryModule::t('shop', 'PHONE_ADDITIONAL'),
            'phone_additional_comment' => DirectoryModule::t('shop', 'PHONE_ADDITIONAL_COMMENT'),
            'fax' => DirectoryModule::t('shop', 'FAX'),
            'email' => DirectoryModule::t('shop', 'EMAIL'),
            'network' => DirectoryModule::t('shop', 'NETWORK'),
            'categories' =>DirectoryModule::t('shop', 'GOODS_CATEGORIES'),
            'logo_image' => DirectoryModule::t('shop', 'LOGO_IMAGE'),
            'main_image' => DirectoryModule::t('shop', 'MAIN_IMAGE'),
            'additional_image' => DirectoryModule::t('shop', 'ADDITIONAL_IMAGE'),
            'site' => DirectoryModule::t('shop', 'SITE'),
            'facebook' => DirectoryModule::t('shop', 'FACEBOOK'),
            'instagram' => DirectoryModule::t('shop', 'INSTAGRAM'),
            'translationShortDescription' => DirectoryModule::t('shop', 'TRANSLATION_SHORT_DESCRIPTION'),
            'translationDescription' => DirectoryModule::t('shop', 'TRANSLATION_DESCRIPTION'),
        ];
    }

    public function behaviors(){
        return [
            'imageBehavior' => [
                'class' => ImageBehavior::className(),
            ]
        ];
    }
}