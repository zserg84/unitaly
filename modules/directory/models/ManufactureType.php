<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use Yii;
use modules\directory\Module as DirectoryModule;

/**
 * This is the model class for table "manufacture_type".
 *
 * @property integer $id
 *
 * @property Manufacture[] $manufactures
 * @property ManufactureTypeLang[] $manufactureTypeLangs
 */
class ManufactureType extends \yii\db\ActiveRecord
{
    public $name;
    public $description;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manufacture_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('manufacture-type', 'IDENTIFIER'),
            'name' => DirectoryModule::t('manufacture-type', 'NAME'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => ManufactureTypeLang::className(),
                'relationFieldName' => 'manufacture_type_id',
                'translateFieldNames' => ['name', 'description'],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufactures()
    {
        return $this->hasMany(Manufacture::className(), ['manufacture_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufactureTypeLangs()
    {
        return $this->hasMany(ManufactureTypeLang::className(), ['manufacture_type_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ManufactureTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ManufactureTypeQuery(get_called_class());
    }
}
