<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 05.06.15
 * Time: 12:03
 */

namespace modules\directory\models\form;


use modules\base\behaviors\ImageBehavior;
use modules\base\Module as BaseModule;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\TourType;
use modules\directory\models\TourTypeLang;
use modules\translations\models\Lang;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use yii\helpers\VarDumper;

class TourTypeForm extends Model
{
    public $id;
    public $translationName = [];
    public $image;
    public $translationDescription = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['translationName', EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
            [['translationName', 'translationDescription', 'id'], 'safe'],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['translationName', LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
            ['translationName', LangUniqueValidator::className(), 'targetClass' => TourTypeLang::className(), 'targetAttribute' => 'name',
                'filter' => function($query){
                    $query->innerJoinWith([
                        'tourType' => function($query){
                            if($this->id)
                                $query->andWhere(['<>', 'tour_type.id', $this->id]);
                        }
                    ]);
                }
            ],
            ['image', 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('tour', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
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
        return [
            'id' => DirectoryModule::t('tour-type', 'IDENTIFIER'),
            'translationName' => DirectoryModule::t('tour-type', 'TRANSLATION_NAME'),
            'translationDescription' => DirectoryModule::t('tour-type', 'TRANSLATION_DESCRIPTION'),
            'image' => DirectoryModule::t('tour-type', 'IMAGE'),
        ];
    }

}