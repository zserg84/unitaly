<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.06.15
 * Time: 11:31
 */

namespace modules\directory\models\form;

use modules\base\behaviors\ImageBehavior;
use modules\base\Module as BaseModule;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\ShopCategoryLang;
use modules\directory\models\ShopType;
use modules\directory\Module as DirectoryModule;
use yii\base\Model;

class ShopCategoryForm extends Model{

    public $id;
    public $translationName = [];
    public $image;
    public $translationDescription = [];

    public $shop_type_id = ShopType::TYPE_STORE;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['translationName', 'translationDescription'], EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
            [['translationName', 'translationDescription', 'id', 'shop_type_id'], 'safe'],
            ['image', 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('tour', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['translationName', LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
            ['translationName', LangUniqueValidator::className(), 'targetClass' => ShopCategoryLang::className(), 'targetAttribute' => 'name',
                'filter' => function($query){
                    $query->innerJoinWith([
                        'shopCategory' => function($query){
                            if($this->id)
                                $query->andWhere(['<>', 'shop_category.id', $this->id]);
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
            'id' => DirectoryModule::t('shop-category', 'IDENTIFIER'),
            'translationName' => DirectoryModule::t('shop-category', 'TRANSLATION_NAME'),
            'translationDescription' => DirectoryModule::t('shop-category', 'TRANSLATION_DESCRIPTION'),
            'image' => DirectoryModule::t('shop-category', 'IMAGE'),
        ];
    }
} 