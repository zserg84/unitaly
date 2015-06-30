<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 29.06.15
 * Time: 17:19
 */

namespace modules\directory\models\form;

use modules\base\Module as BaseModule;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\Manufacture;
use modules\directory\models\ManufactureLang;
use modules\directory\Module as DirectoryModule;
use modules\base\behaviors\ImageBehavior;
use modules\base\validators\EachValidator;
use yii\base\Model;

class ManufactureForm extends Manufacture
{

    public $region_id;
    public $province_id;
    public $translationName = [];
    public $translationSpellings = [];
    public $translationMediafaceName = [];
    public $translationWorktime = [];
    public $image;

    public function rules()
    {
        return [
            [['translationName', 'translationSpellings', 'translationMediafaceName', 'translationWorktime'], EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
            [['manufacture_type_id', 'legal_entity', 'region_id', 'province_id', 'city_id', 'address', 'latitude', 'longitude'], 'required'],
            [['frontend', 'manufacture_type_id', 'city_id'], 'integer'],
            [['id', 'frontend', 'translationName', 'translationSpellings', 'legal_entity', 'network', 'associations', 'manufacture_type_id', 'translationMediafaceName',
                'mediaface_appeal', 'city_id', 'address', 'latitude', 'longitude', 'translationWorktime', 'phone', 'email', 'site', 'purchase_url', 'facebook', 'instagram'], 'safe'],
            [['email'], 'email'],
            [['image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('manufacture', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['translationName', LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
            ['translationName', LangUniqueValidator::className(), 'targetClass' => ManufactureLang::className(), 'targetAttribute' => 'name',
                'filter' => function($query){
                    $query->innerJoinWith([
                        'manufacture' => function($query){
                            if($this->id)
                                $query->andWhere(['<>', 'manufacture.id', $this->id]);
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return array_merge($labels,
            [
                'image' => DirectoryModule::t('manufacture', 'IMAGE'),
                'region_id' => DirectoryModule::t('manufacture', 'REGION_ID'),
                'province_id' => DirectoryModule::t('manufacture', 'PROVINCE_ID'),
                'mediaface_image' => DirectoryModule::t('manufacture', 'MEDIAFACE_IMAGE'),
                'translationName' => DirectoryModule::t('manufacture', 'NAME'),
                'translationSpellings' => DirectoryModule::t('manufacture', 'SPELLINGS'),
                'translationMediafaceName' => DirectoryModule::t('manufacture', 'MEDIAFACE_NAME'),
                'translationWorktime' => DirectoryModule::t('manufacture', 'WORKTIME'),
            ]
        );
    }
} 