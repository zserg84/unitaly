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
use modules\directory\models\Hub;
use modules\directory\models\HubLang;
use modules\image\models\Image;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use yii\helpers\VarDumper;
use Yii;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\EachValidator;
use modules\base\Module as BaseModule;

class HubForm extends Model
{
	public $id;
	public $translationName = [];
	public $translationDescription = [];
	public $region_id;
	public $province_id;
	public $city_id;
	public $image;
	public $description;
	public $airport;
	public $port;
	public $code_iata;
	public $code_icao;
	public $arrival_table;
	public $departure_table;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	        [['airport', 'port', 'code_iata', 'code_icao', 'arrival_table', 'departure_table'], 'filter', 'filter' => 'trim'],
	        [['region_id', 'province_id', 'city_id'], 'required'],
	        [['description'], 'string'],
	        [['airport', 'port', 'arrival_table', 'departure_table'], 'string', 'max' => 255],
	        [['code_iata', 'code_icao'], 'filter', 'filter' => 'trim'],
	        [['code_iata'], 'string', 'max' => 3],
	        [['code_icao'], 'string', 'max' => 4],
	        [['arrival_table', 'departure_table'], 'url', 'defaultScheme' => 'http'],
	        [['region_id', 'city_id'], 'integer'],
            [['image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('hub', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
	        [['translationName', 'translationDescription'], EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
	        [['translationName'], EachValidator::className(), 'rule'=>['string', 'max'=>50]],
	        [['translationName'], LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
	        ['translationName', LangUniqueValidator::className(),'targetClass' => HubLang::className(), 'targetAttribute' => 'name',
	                                                             'filter' => function($query){
		                                                             $query->innerJoinWith([
			                                                             'hub' => function($query){
				                                                             if($this->id)
					                                                             $query->andWhere(['<>', 'hub.id', $this->id]);
			                                                             }
		                                                             ]);
	                                                             }, 'message' => DirectoryModule::t('hub', 'HUB_EXIST')
	        ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
	    return [
		    'id' => DirectoryModule::t('hub', 'ID'),
		    'translationName' => DirectoryModule::t('hub', 'NAME'),
		    'spellings' => DirectoryModule::t('hub', 'SPELLINGS'),
		    'region_id' => DirectoryModule::t('hub', 'REGION_ID'),
		    'province_id' => DirectoryModule::t('hub', 'PROVINCE_ID'),
		    'city_id' => DirectoryModule::t('hub', 'CITY_ID'),
		    'image' => DirectoryModule::t('hub', 'IMAGE'),
		    'airport' => DirectoryModule::t('hub', 'AIRPORT'),
		    'port' => DirectoryModule::t('hub', 'PORT'),
		    'description' => DirectoryModule::t('hub', 'DESCRIPTION'),
		    'code_iata' => DirectoryModule::t('hub', 'CODE_IATA'),
		    'code_icao' => DirectoryModule::t('hub', 'CODE_ICAO'),
		    'arrival_table' => DirectoryModule::t('hub', 'ARRIVAL_TABLE'),
		    'departure_table' => DirectoryModule::t('hub', 'DEPARTURE_TABLE'),
		    'translationDescription' => DirectoryModule::t('hub', 'DESCRIPTION'),
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