<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\image\models\Image;
use modules\translations\models\Lang;
use Yii;
use yii\base\Model;
use modules\base\behaviors\TranslateBehavior;
use modules\directory\Module as DirectoryModule;


/**
 * This is the model class for table "placement_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $subtype_id
 * @property integer $image_id
 *
 * @property PlacementSubType $subtype
 * @property PlacementTypeLang[] $placementTypeLangs
 */
class PlacementType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'placement_type';
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => PlacementTypeLang::className(),
                'relationFieldName' => 'placement_type_id',
                'translateFieldNames' => ['name'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subtype_id', 'image_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('placement-type', 'IDENTIFIER'),
            'name' => DirectoryModule::t('placement-type', 'TRANSLATION_NAME'),
            'subtype_id' => DirectoryModule::t('placement-type', 'SUBTYPE_ID'),
            'image_id' => DirectoryModule::t('placement-type', 'IMAGE_ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubtype()
    {
        return $this->hasOne(PlacementSubType::className(), ['id' => 'subtype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacementTypeLangs()
    {
        return $this->hasMany(PlacementTypeLang::className(), ['placement_type_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\PlacementTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\PlacementTypeQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

}
