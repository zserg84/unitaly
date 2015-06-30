<?php

namespace modules\directory\models\form;

use Yii;
use modules\base\behaviors\ImageBehavior;
use modules\image\models\Image;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use modules\directory\models\PlacementType;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\PlacementTypeLang;


class PlacementTypeForm extends Model
{
    public $id;
    public $name;
    public $image;
    public $image_id;
    public $translationName = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'integer'],
            [['image_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('placement-type', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['translationName', LangRequiredValidator::className()],
            ['translationName', LangUniqueValidator::className(), 
                'targetClass' => PlacementTypeLang::className(), 'targetAttribute' => 'name'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image' => DirectoryModule::t('placement-type', 'IMAGE_ID'),
            'translationName' => DirectoryModule::t('placement-type', 'TRANSLATION_NAME'),
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
