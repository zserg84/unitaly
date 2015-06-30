<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 04.06.15
 * Time: 10:31
 */

namespace modules\directory\models\form;


use modules\base\behaviors\ImageBehavior;
use modules\base\Module as BaseModule;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\ShowplaceType;
use modules\directory\models\ShowplaceTypeLang;
use modules\directory\Module as DirectoryModule;
use modules\base\Module as BaseModule;
use yii\base\Model;

class ShowplaceTypeForm extends Model
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
            [['translationName', 'translationDescription'], EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
            [['translationName', 'translationDescription', 'id'], 'safe'],
            ['image', 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('tour', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['translationName', LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
            ['translationName', LangUniqueValidator::className(), 'targetClass' => ShowplaceTypeLang::className(), 'targetAttribute' => 'name',
                'filter' => function($query){
                    $query->innerJoinWith([
                        'showplaceType' => function($query){
                            if($this->id)
                                $query->andWhere(['<>', 'showplace_type.id', $this->id]);
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
            'id' => DirectoryModule::t('showplace-type', 'IDENTIFIER'),
            'translationName' => DirectoryModule::t('showplace-type', 'TRANSLATION_NAME'),
            'translationDescription' => DirectoryModule::t('showplace-type', 'TRANSLATION_DESCRIPTION'),
            'image' => DirectoryModule::t('showplace-type', 'IMAGE'),
        ];
    }
} 