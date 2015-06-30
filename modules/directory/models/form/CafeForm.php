<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 22.06.15
 * Time: 12:51
 */

namespace modules\directory\models\form;


use modules\base\behaviors\ImageBehavior;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use modules\themes\Module as ThemeModule;
use modules\base\Module as BaseModule;

class CafeForm extends Model
{

    public $id;
    public $logo_image;
    public $frontend;
    public $translationName = [];
    public $translationSpellings = [];
    public $rest_net;
    public $region_id;
    public $province_id;
    public $city_id;
    public $address;
    public $placement_id;
    public $latitude;
    public $longitude;
    public $translationWorktime = [];
    public $site;
    public $facebook;
    public $instagram;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['translationName', EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
            [['region_id', 'province_id', 'city_id', 'address'], 'required'],
            [['frontend', 'region_id', 'province_id', 'city_id', 'placement_id', 'id'], 'integer'],
            [['latitude', 'longitude', 'rest_net', 'site', 'facebook', 'instagram'], 'string', 'max' => 255],
            [['logo_image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>ThemeModule::t('themes-admin', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            [['translationName'], LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
            [['translationWorktime'], LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
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
            'translationName' => DirectoryModule::t('cafe', 'TRANSLATION_NAME'),
            'translationSpellings' => DirectoryModule::t('cafe', 'TRANSLATION_SPELLINGS'),
            'rest_net' => DirectoryModule::t('cafe', 'REST_NET'),
            'region_id' => DirectoryModule::t('cafe', 'REGION_ID'),
            'province_id' => DirectoryModule::t('cafe', 'PROVINCE_ID'),
            'city_id' => DirectoryModule::t('cafe', 'CITY_ID'),
            'latitude' => DirectoryModule::t('cafe', 'LATITUDE'),
            'longitude' => DirectoryModule::t('cafe', 'LONGITUDE'),
            'logo_image' => DirectoryModule::t('cafe', 'LOGO_IMAGE'),
            'address' => DirectoryModule::t('cafe', 'ADDRESS'),
            'placement_id' => DirectoryModule::t('cafe', 'PLACEMENT_ID'),
            'translationWorktime' => DirectoryModule::t('cafe', 'TRANSLATION_WORKTIME'),
            'site' => DirectoryModule::t('cafe', 'SITE'),
            'facebook' => DirectoryModule::t('cafe', 'FACEBOOK'),
            'instagram' => DirectoryModule::t('cafe', 'INSTAGRAM'),
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