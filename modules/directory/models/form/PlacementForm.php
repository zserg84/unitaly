<?php

namespace modules\directory\models\form;

use Yii;
use modules\base\behaviors\ImageBehavior;
use modules\image\models\Image;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use modules\directory\models\Placement;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\PlacementLang;


class PlacementForm extends Model
{
    public $id;
    public $frontend;
    public $translationName = [];
    public $spellings;
    public $placement_type_id;
    public $placement_sub_type_id;
    public $placement_net;
    public $rooms;
    public $cheap;
    public $expensive;
    public $region_id;
    public $city_id;
    public $logo_image;
    public $add_image;
    public $logo_image_id;
    public $add_image_id;
    public $logoImage;
    public $addImage;
    public $address;
    public $main_phone;
    public $add_phone;
    public $fax;
    public $email;
    public $site;
    public $facebook;
    public $instagram;
    public $desc_short;
    public $desc_full;
    public $latitude;
    public $longitude;
    public $hub_id;
    public $services;
    public $name;
    public $province_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frontend', 'translationName', 'spellings',
                'placement_type_id', /* 'placement_sub_type_id', */ 'rooms',
                'cheap', 'expensive', 'region_id', /*city_id',*/ 'address',
                'main_phone', 'fax', 'email', 'desc_short', 'hub_id'], 'required'],
            [['frontend', 'placement_type_id', 'placement_sub_type_id', 'rooms',
                'region_id', /*'city_id',*/ 'logo_image_id', 'add_image_id', 'hub_id'], 'integer'],
            [['name', 'spellings', 'placement_net', 'cheap', 'expensive', 'address',
                'main_phone', 'add_phone', 'fax', 'email', 'site', 'facebook', 'instagram',
                'desc_short', 'desc_full', 'services', 'latitude', 'longitude'], 'string', 'max' => 255],
            [['logoImage', 'addImage'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('placement', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            [['email'], 'email'],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['translationName', LangRequiredValidator::className()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('placement', 'ID'),
            'frontend' => DirectoryModule::t('placement', 'FRONTEND'),
            'translationName' => DirectoryModule::t('placement', 'TRANSLATION_NAME'),
            'spellings' => DirectoryModule::t('placement', 'SPELLINGS'),
            'placement_type_id' => DirectoryModule::t('placement', 'PLACEMENT_TYPE_ID'),
            'placement_sub_type_id' => DirectoryModule::t('placement', 'PLACEMENT_SUB_TYPE_ID'),
            'placement_net' => DirectoryModule::t('placement', 'PLACEMENT_NET'),
            'rooms' => DirectoryModule::t('placement', 'ROOMS'),
            'cheap' => DirectoryModule::t('placement', 'CHEAP'),
            'expensive' => DirectoryModule::t('placement', 'EXPENSIVE'),
            'region_id' => DirectoryModule::t('placement', 'REGION_ID'),
            'city_id' => DirectoryModule::t('placement', 'CITY_ID'),
            'logo_image' => DirectoryModule::t('placement', 'LOGO_IMAGE'),
            'add_image' => DirectoryModule::t('placement', 'ADD_IMAGE'),
            'address' => DirectoryModule::t('placement', 'ADDRESS'),
            'main_phone' => DirectoryModule::t('placement', 'MAIN_PHONE'),
            'add_phone' => DirectoryModule::t('placement', 'ADD_PHONE'),
            'fax' => DirectoryModule::t('placement', 'FAX'),
            'email' => DirectoryModule::t('placement', 'EMAIL'),
            'site' => DirectoryModule::t('placement', 'SITE'),
            'facebook' => DirectoryModule::t('placement', 'FACEBOOK'),
            'instagram' => DirectoryModule::t('placement', 'INSTAGRAM'),
            'desc_short' => DirectoryModule::t('placement', 'DESC_SHORT'),
            'desc_full' => DirectoryModule::t('placement', 'DESC_FULL'),
            'latitude' => DirectoryModule::t('placement', 'LATITUDE'),
            'longitude' => DirectoryModule::t('placement', 'LONGITUDE'),
            'hub_id' => DirectoryModule::t('placement', 'HUB_ID'),
            'services' => DirectoryModule::t('placement', 'SERVICES'),
            'tabs_char' => DirectoryModule::t('placement', 'TABS_CHAR'),
            'tabs_opts' => DirectoryModule::t('placement', 'TABS_OPTS'),
            'province_id' => DirectoryModule::t('province', 'IDENTIFIER'),
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
