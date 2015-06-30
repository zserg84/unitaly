<?php

namespace modules\directory\models\form;


use modules\base\behaviors\ImageBehavior;
use modules\base\Module as BaseModule;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\RoomType;
use modules\directory\models\RoomTypeLang;
use modules\directory\Module as DirectoryModule;
use yii\base\Model;

class RoomTypeForm extends Model
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
            ['image', 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('tour', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
	        [['translationName', 'translationDescription'], EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
	        ['translationName', LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
            ['translationName', LangUniqueValidator::className(), 'targetClass' => RoomTypeLang::className(), 'targetAttribute' => 'name',
                'filter' => function($query){
                    $query->innerJoinWith([
                        'roomType' => function($query){
                            if($this->id)
                                $query->andWhere(['<>', 'room_type.id', $this->id]);
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
        return [
            'id' => DirectoryModule::t('room-type', 'IDENTIFIER'),
            'translationName' => DirectoryModule::t('room-type', 'TRANSLATION_NAME'),
            'translationDescription' => DirectoryModule::t('room-type', 'TRANSLATION_DESCRIPTION'),
            'image' => DirectoryModule::t('room-type', 'IMAGE'),
        ];
    }
} 