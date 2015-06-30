<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 30.06.15
 * Time: 10:33
 */

namespace modules\directory\models\form;

use modules\base\Module as BaseModule;
use modules\directory\Module as DirectoryModule;
use modules\base\behaviors\ImageBehavior;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\ManufactureType;
use modules\directory\models\ManufactureTypeLang;

class ManufactureTypeForm extends ManufactureType
{

    public $translationName;
    public $translationDescription;
    
    public function rules()
    {
        return [
            [['translationName', 'translationDescription'], EachValidator::className(), 'rule'=>['filter', 'filter'=>'trim']],
            [['translationName', 'translationDescription', 'id'], 'safe'],
            ['translationName', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['translationName', LangRequiredValidator::className(), 'langUrls' => BaseModule::getSystemLanguage()],
            ['translationName', LangUniqueValidator::className(), 'targetClass' => ManufactureTypeLang::className(), 'targetAttribute' => 'name',
                'filter' => function($query){
                    $query->innerJoinWith([
                        'manufactureType' => function($query){
                            if($this->id)
                                $query->andWhere(['<>', 'manufacture_type.id', $this->id]);
                        }
                    ]);
                }
            ],
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return array_merge($labels,
            [
                'translationName' => DirectoryModule::t('manufacture-type', 'NAME'),
                'translationDescription' => DirectoryModule::t('manufacture-type', 'DESCRIPTION'),
            ]
        );
    }
}