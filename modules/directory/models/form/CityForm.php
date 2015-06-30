<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 02.06.15
 * Time: 15:05
 */

namespace modules\directory\models\form;

use modules\base\behaviors\ImageBehavior;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\City;
use modules\directory\models\CityLang;
use modules\image\models\Image;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use yii\helpers\VarDumper;
use Yii;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\EachValidator;
use modules\base\Module as BaseModule;

class CityForm extends Model
{
	public $id;
	public $translationName = [];
	public $translationDescription = [];
	public $translationHistory = [];
	public $translationSpellings = [];
	public $spellings;
	public $region_id;
	public $province_id;
	public $visit_image;
	public $arms_image;
	public $description;
	public $latitude;
	public $longitude;
	public $hub_id;
	public $history;
	public $main_showplaces;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	        [['region_id'], 'filter', 'filter' => 'trim'],
	        [['region_id'], 'filter', 'filter' => function($value){return ($value == '') ? null: $value;}],
            [['province_id'], 'required'],
	        [['spellings', 'description', 'history'], 'string'],
	        [['province_id', 'hub_id'], 'integer'],
	        [['latitude', 'longitude'], 'filter', 'filter' => 'trim'],
	        [['latitude', 'longitude'], 'string', 'max' => 255],
            [['visit_image', 'arms_image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('city', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
	        [['main_showplaces', 'translationDescription', 'translationSpellings', 'translationHistory'], 'safe'],
	        [['translationName', 'translationSpellings', 'translationDescription', 'translationHistory'], EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
	        [['translationName'], EachValidator::className(), 'rule'=>['string', 'max'=>50]],
	        [['translationName'], LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
	        ['translationName', LangUniqueValidator::className(), 'targetClass' => CityLang::className(), 'targetAttribute' => 'name',
	                                                              'filter' => function($query){
		                                                              $query->innerJoinWith([
			                                                              'city' => function($query){
				                                                              if($this->id)
					                                                              $query->andWhere(['<>', 'city.id', $this->id]);
				                                                              $query->andWhere([
					                                                              'province_id' => $this->province_id,
				                                                              ]);
			                                                              }
		                                                              ]);
	                                                              }, 'message' => DirectoryModule::t('city', 'CITY_EXIST_IN_PROVINCE')
	        ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
	    return [
		    'id' => DirectoryModule::t('city', 'ID'),
		    'translationName' => DirectoryModule::t('city', 'NAME'),
		    'spellings' => DirectoryModule::t('city', 'SPELLINGS'),
		    'region_id' => DirectoryModule::t('city', 'REGION_ID'),
		    'province_id' => DirectoryModule::t('city', 'PROVINCE_ID'),
		    'visit_image' => DirectoryModule::t('city', 'VISIT_IMAGE'),
		    'arms_image' => DirectoryModule::t('city', 'ARMS_IMAGE'),
		    'description' => DirectoryModule::t('city', 'DESCRIPTION'),
		    'latitude' => DirectoryModule::t('city', 'LATITUDE'),
		    'longitude' => DirectoryModule::t('city', 'LONGITUDE'),
		    'hub_id' => DirectoryModule::t('city', 'HUB_ID'),
		    'history' => DirectoryModule::t('city', 'HISTORY'),
		    'translationDescription' => DirectoryModule::t('city', 'DESCRIPTION'),
		    'translationHistory' => DirectoryModule::t('city', 'HISTORY'),
		    'translationSpellings' => DirectoryModule::t('city', 'SPELLINGS'),
		    'main_showplaces' => DirectoryModule::t('city', 'MAIN_SHOWPLACES'),
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