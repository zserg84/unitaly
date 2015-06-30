<?php
/**
 * Базовая форма для разных опций
 */

namespace modules\directory\models\form;

use modules\base\behaviors\ImageBehavior;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use Yii;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\EachValidator;
use modules\base\validators\OptionsUniqueValidator;
use modules\base\Module as BaseModule;

class OptionsForm extends Model
{
	public $id;
	public $modelClass;
	public $messageFileName;
	public $category;
	public $service_type_id;
	public $translationName = [];
	public $translationDescription = [];
	public $image;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t($this->messageFileName, 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
	        [['translationName', 'translationDescription'], EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
	        [['translationName'], EachValidator::className(), 'rule'=>['string', 'max'=>50]],
	        [['translationName'], OptionsUniqueValidator::className(), 'message' => DirectoryModule::t($this->messageFileName, 'OPTION_EXIST')],
	        [['translationDescription'], EachValidator::className(), 'rule'=>['string']],
	        [['translationName'], LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
	        [['service_type_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
	    return [
		    'id' => DirectoryModule::t($this->messageFileName, 'ID'),
		    'translationName' => DirectoryModule::t($this->messageFileName, 'NAME'),
		    'image' => DirectoryModule::t($this->messageFileName, 'IMAGE'),
		    'description' => DirectoryModule::t($this->messageFileName, 'DESCRIPTION'),
		    'translationDescription' => DirectoryModule::t($this->messageFileName, 'DESCRIPTION'),
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