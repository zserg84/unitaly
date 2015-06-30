<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 10.06.15
 * Time: 16:35
 */

namespace modules\directory\models\form;


use modules\base\behaviors\ImageBehavior;
use modules\base\Module as BaseModule;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\Tour;
use modules\directory\models\TourLang;
use modules\directory\Module as DirectoryModule;
use yii\base\Model;
use yii\helpers\VarDumper;

class TourForm extends Model
{

    public $id;
    public $frontend;
    public $provider_id;
    public $seller_name;
    public $seller_phone;
    public $seller_email;
    public $tour_type_id;
    public $translationName = [];
    public $days_cnt;
    public $nights_cnt;
    public $region_id;
    public $province_id;
    public $city_id;
    public $date_start;
    public $price;
    public $tour_offer_type_id;
    public $short_description;
    public $description;
    public $image;
    public $additional_image;
    public $food_type_id;

    public function rules()
    {
        return [
            ['translationName', EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
            [['provider_id', 'tour_type_id', 'region_id', 'province_id', 'city_id', 'date_start', 'days_cnt', 'nights_cnt', 'price'], 'required'],
            [['provider_id', 'tour_type_id', 'days_cnt', 'nights_cnt', 'city_id', 'food_type_id', 'tour_offer_type_id', 'frontend'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['short_description', 'seller_name', 'seller_phone', 'seller_email'], 'string', 'max' => 255],
            [['id', 'frontend', 'provider_id', 'seller_name', 'seller_phone', 'seller_email', 'translationName', 'days_cnt', 'nights_cnt',
                'region_id', 'province_id', 'city_id', 'date_start', 'price', 'tour_offer_type_id', 'short_description', 'description'], 'safe'],
            [['seller_email'], 'email'],
            [['image', 'additional_image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('showplace', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['translationName', LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
            ['translationName', LangUniqueValidator::className(), 'targetClass' => TourLang::className(), 'targetAttribute' => 'name',
                'filter' => function($query){
                    $query->innerJoinWith([
                        'tour' => function($query){
                            if($this->id)
                                $query->andWhere(['<>', 'tour.id', $this->id]);
                            $query->andWhere([
                                'tour_type_id' => $this->tour_type_id,
                            ]);
                        }
                    ]);
                }
            ],
        ];
    }

    public function behaviors(){
        return [
            'imageBehavior' => [
                'class' => ImageBehavior::className(),
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('tour', 'IDENTIFIER'),
            'provider_id' => DirectoryModule::t('tour', 'PROVIDER_ID'),
            'tour_type_id' => DirectoryModule::t('tour', 'TOUR_TYPE_ID'),
            'name' => DirectoryModule::t('tour', 'NAME'),
            'translationName' => DirectoryModule::t('tour', 'TRANSLATION_NAME'),
            'days_cnt' => DirectoryModule::t('tour', 'DAYS_CNT'),
            'nights_cnt' => DirectoryModule::t('tour', 'NIGHTS_CNT'),
            'region_id' => DirectoryModule::t('tour', 'REGION_ID'),
            'province_id' => DirectoryModule::t('tour', 'PROVINCE_ID'),
            'city_id' => DirectoryModule::t('tour', 'CITY_ID'),
            'date_start' => DirectoryModule::t('tour', 'DATE_START'),
            'price' => DirectoryModule::t('tour', 'PRICE'),
            'food_type_id' => DirectoryModule::t('tour', 'FOOD_TYPE_ID'),
            'short_description' => DirectoryModule::t('tour', 'SHORT_DESCRIPTION'),
            'description' => DirectoryModule::t('tour', 'DESCRIPTION'),
            'seller_name' => DirectoryModule::t('tour', 'SELLER_NAME'),
            'seller_phone' => DirectoryModule::t('tour', 'SELLER_PHONE'),
            'seller_email' => DirectoryModule::t('tour', 'SELLER_EMAIL'),
            'image' => DirectoryModule::t('tour', 'IMAGE'),
            'additional_image' => DirectoryModule::t('tour', 'ADDITIONAL_IMAGE'),
            'tour_offer_type_id' => DirectoryModule::t('tour', 'TOUR_OFFER_TYPE_ID'),
            'frontend' => DirectoryModule::t('tour', 'FRONTEND'),
        ];
    }
} 