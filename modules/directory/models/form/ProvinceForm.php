<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 19.06.15
 * Time: 14:28
 */

namespace modules\directory\models\form;


use modules\base\behaviors\ImageBehavior;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\ProvinceLang;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use modules\base\Module as BaseModule;

class ProvinceForm extends Model
{
    public $id;
    public $region_id;
    public $translationName = [];
    public $translationDescription = [];
    public $translationSpellings = [];
    public $city_id;
    public $visit_image;
    public $flag_image;
    public $arms_image;

    public function rules()
    {
        return [
            ['translationName', EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
            [['region_id'], 'required'],
            [['region_id', 'city_id'], 'integer'],
            [['visit_image', 'flag_image', 'arms_image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('province', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            [['id', 'translationName', 'translationDescription', 'translationSpellings'], 'safe'],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['translationName', LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
            ['translationName', LangUniqueValidator::className(), 'targetClass' => ProvinceLang::className(), 'targetAttribute' => 'name',
                'filter' => function($query){
                    $query->innerJoinWith([
                        'province' => function($query){
                            if($this->id)
                                $query->andWhere(['<>', 'province.id', $this->id]);
                            $query->andWhere([
                                'region_id' => $this->region_id,
                            ]);
                        }
                    ]);
                }, 'message' => DirectoryModule::t('province', 'PROVINCE_EXIST_IN_REGION')
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
            'id' => DirectoryModule::t('province', 'IDENTIFIER'),
            'region_id' => DirectoryModule::t('province', 'REGION_ID'),
            'translationName' => DirectoryModule::t('province', 'NAME'),
            'spellings' => DirectoryModule::t('province', 'SPELLINGS'),
            'visit_image' => DirectoryModule::t('province', 'VISIT_IMAGE'),
            'flag_image' => DirectoryModule::t('province', 'FLAG_IMAGE'),
            'arms_image' => DirectoryModule::t('province', 'ARMS_IMAGE'),
            'city_id' => DirectoryModule::t('province', 'CITY'),
            'translationDescription' => DirectoryModule::t('province', 'DESCRIPTION'),
            'translationSpellings' => DirectoryModule::t('province', 'SPELLINGS'),
        ];
    }
} 