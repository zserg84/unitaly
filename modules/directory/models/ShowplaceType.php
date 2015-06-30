<?php

namespace modules\directory\models;

use modules\base\behaviors\TranslateBehavior;
use modules\directory\Module as DirectoryModule;
use modules\base\behaviors\LangSaveBehavior;
use modules\image\models\Image;
use modules\directory\models\ShowplaceTypeLang;
use modules\translations\models\Lang;
use Yii;

/**
 * This is the model class for table "showplace_type".
 *
 * @property integer $id
 * @property integer $identifier
 * @property string $name
 * @property string $description
 * @property integer $image_id
 *
 * @property Showplace[] $showplaces
 * @property Image $image
 * @property ShowplaceTypeLang[] $showplaceTypeLangs
 */
class ShowplaceType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'showplace_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('showplace-type', 'IDENTIFIER'),
            'name' => DirectoryModule::t('showplace-type', 'TRANSLATION_NAME'),
            'description' => DirectoryModule::t('showplace-type', 'TRANSLATION_DESCRIPTION'),
            'nameTranslate' => DirectoryModule::t('showplace-type', 'TRANSLATION_NAME'),
            'descriptionTranslate' => DirectoryModule::t('showplace-type', 'TRANSLATION_DESCRIPTION'),
            'image' => DirectoryModule::t('showplace-type', 'IMAGE'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => ShowplaceTypeLang::className(),
                'relationFieldName' => 'showplace_type_id',
                'translateFieldNames' => ['name', 'description'],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShowplaces()
    {
        return $this->hasMany(Showplace::className(), ['showplace_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShowplaceTypeLangs()
    {
        return $this->hasMany(ShowplaceTypeLang::className(), ['showplace_type_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShowplaceTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShowplaceTypeQuery(get_called_class());
    }
}
