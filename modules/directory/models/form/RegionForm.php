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
use modules\directory\models\Region;
use modules\directory\models\RegionLang;
use modules\image\models\Image;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use yii\helpers\VarDumper;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\EachValidator;
use modules\base\Module as BaseModule;

class RegionForm extends Model
{
	public $id;
	public $translationName = [];
	public $translationDescription = [];
	public $translationSpellings = [];
	public $spellings;
	public $city_id;
	public $visit_image;
	public $flag_image;
	public $arms_image;
	public $description;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	        [['spellings', 'description'], 'string'],
	        [['city_id'], 'integer'],
            [['visit_image', 'flag_image', 'arms_image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('region', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
	        [['translationName', 'translationSpellings', 'translationDescription'], EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
	        [['translationName'], EachValidator::className(), 'rule'=>['string', 'max'=>50]],
	        [['translationName', 'translationDescription'], LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
	        ['translationName', LangUniqueValidator::className(),'targetClass' => RegionLang::className(), 'targetAttribute' => 'name',
	                                                              'filter' => function($query){
		                                                              $query->innerJoinWith([
			                                                              'region' => function($query){
				                                                              if($this->id)
					                                                              $query->andWhere(['<>', 'region.id', $this->id]);
			                                                              }
		                                                              ]);
	                                                              }, 'message' => DirectoryModule::t('region', 'REGION_EXIST')
	        ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
	        'id' => DirectoryModule::t('region', 'ID'),
	        'translationName' => DirectoryModule::t('region', 'NAME'),
	        'spellings' => DirectoryModule::t('region', 'SPELLINGS'),
	        'visit_image' => DirectoryModule::t('region', 'VISIT_IMAGE'),
	        'flag_image' => DirectoryModule::t('region', 'FLAG_IMAGE'),
	        'arms_image' => DirectoryModule::t('region', 'ARMS_IMAGE'),
	        'city_id' => DirectoryModule::t('region', 'CITY'),
	        'translationDescription' => DirectoryModule::t('region', 'DESCRIPTION'),
	        'translationSpellings' => DirectoryModule::t('region', 'SPELLINGS'),
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