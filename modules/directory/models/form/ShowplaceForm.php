<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 02.06.15
 * Time: 15:05
 */

namespace modules\directory\models\form;

use modules\base\behaviors\ImageBehavior;
use modules\base\Module as BaseModule;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\directory\models\Showplace;
use modules\image\models\Image;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use yii\helpers\VarDumper;

class ShowplaceForm extends Model
{
    public $org_service_provider;
    public $showplace_type_id;
//    public $name;
    public $translationName = [];
    public $region_id;
    public $province_id;
    public $city_id;
    public $address;
    public $latitude;
    public $longitude;
    public $image;
    public $additional_image;
    public $translationShortDescription;
    public $translationDescription;
    public $representative_name;
    public $representative_phone;
    public $representative_email;
    public $site;
    public $facebook;
    public $instagram;
    public $price_adult;
    public $price_child;
    public $schedule;
    public $has_excursion;
    public $price_excursion_guide_group;
    public $price_excursion_guide_individual;
    public $price_excursion_guide_audio;
    public $additional;
    public $main;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['showplace_type_id', 'region_id', 'province_id', 'city_id', 'address', 'latitude', 'longitude'], 'required'],
            [['showplace_type_id', 'region_id', 'province_id', 'city_id', 'has_excursion', 'main'], 'integer'],
            [['org_service_provider', 'additional'], 'string'],
            [['price_adult', 'price_child', 'price_excursion_guide_group', 'price_excursion_guide_individual', 'price_excursion_guide_audio'], 'number'],
            [['address', 'latitude', 'longitude', 'representative_name', 'representative_phone', 'site', 'facebook', 'instagram', 'schedule'], 'string', 'max' => 255],
            [['representative_email'], 'string', 'max' => 50],
            [['representative_email'], 'email'],
            [['image', 'additional_image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('showplace', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            [['translationName'], EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['translationName', LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
            [['translationShortDescription', 'translationDescription'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('showplace', 'IDENTIFIER'),
            'name' => DirectoryModule::t('showplace', 'NAME'),
            'org_service_provider' => DirectoryModule::t('showplace', 'ORG_SERVICE_PROVIDER'),
            'showplace_type_id' => DirectoryModule::t('showplace', 'SHOWPLACE_TYPE_ID'),
            'city_id' => DirectoryModule::t('showplace', 'CITY_ID'),
            'province_id' => DirectoryModule::t('showplace', 'PROVINCE_ID'),
            'region_id' => DirectoryModule::t('showplace', 'REGION_ID'),
            'address' => DirectoryModule::t('showplace', 'ADDRESS'),
            'image' => DirectoryModule::t('showplace', 'IMAGE_ID'),
            'additional_image' => DirectoryModule::t('showplace', 'ADDITIONAL_IMAGE_ID'),
            'latitude' => DirectoryModule::t('showplace', 'LATITUDE'),
            'longitude' => DirectoryModule::t('showplace', 'LONGITUDE'),
            'translationShortDescription' => DirectoryModule::t('showplace', 'TRANSLATION_SHORT_DESCRIPTION'),
            'translationDescription' => DirectoryModule::t('showplace', 'TRANSLATION_DESCRIPTION'),
            'representative_name' => DirectoryModule::t('showplace', 'REPRESENTATIVE_NAME'),
            'representative_phone' => DirectoryModule::t('showplace', 'REPRESENTATIVE_PHONE'),
            'representative_email' => DirectoryModule::t('showplace', 'REPRESENTATIVE_EMAIL'),
            'site' => DirectoryModule::t('showplace', 'SITE'),
            'facebook' => DirectoryModule::t('showplace', 'FACEBOOK'),
            'instagram' => DirectoryModule::t('showplace', 'INSTAGRAM'),
            'price' => DirectoryModule::t('showplace', 'PRICE'),
            'price_adult' => DirectoryModule::t('showplace', 'PRICE_ADULT'),
            'price_child' => DirectoryModule::t('showplace', 'PRICE_CHILD'),
            'schedule' => DirectoryModule::t('showplace', 'SCHEDULE'),
            'has_excursion' => DirectoryModule::t('showplace', 'HAS_EXCURSION'),
            'price_excursion' => DirectoryModule::t('showplace', 'PRICE_EXCURSION'),
            'price_excursion_guide_group' => DirectoryModule::t('showplace', 'PRICE_EXCURSION_GUIDE_GROUP'),
            'price_excursion_guide_individual' => DirectoryModule::t('showplace', 'PRICE_EXCURSION_GUIDE_INDIVIDUAL'),
            'price_excursion_guide_audio' => DirectoryModule::t('showplace', 'PRICE_EXCURSION_GUIDE_AUDIO'),
            'additional' => DirectoryModule::t('showplace', 'ADDITIONAL'),
            'translationName' => DirectoryModule::t('showplace', 'TRANSLATION_NAME'),
            'main' => DirectoryModule::t('showplace', 'MAIN'),
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