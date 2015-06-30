<?php

namespace modules\directory\models;

use modules\base\behaviors\TranslateBehavior;
use modules\directory\Module as DirectoryModule;
use modules\base\behaviors\LangSaveBehavior;
use modules\image\models\Image;
use modules\translations\models\Lang;
use Yii;

/**
 * This is the model class for table "tour_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $image_id
 *
 * @property Image $image
 * @property TourTypeLang[] $tourTypeLangs
 */
class TourType extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour_type';
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
            'id' => DirectoryModule::t('tour-type', 'IDENTIFIER'),
            'name' => DirectoryModule::t('tour-type', 'TRANSLATION_NAME'),
            'description' => DirectoryModule::t('tour-type', 'TRANSLATION_DESCRIPTION'),
            'nameTranslate' => DirectoryModule::t('tour-type', 'TRANSLATION_NAME'),
            'descriptionTranslate' => DirectoryModule::t('tour-type', 'TRANSLATION_DESCRIPTION'),
            'image' => DirectoryModule::t('tour-type', 'IMAGE'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => TourTypeLang::className(),
                'relationFieldName' => 'tour_type_id',
                'translateFieldNames' => ['name', 'description'],
            ],
        ];
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
    public function getTourTypeLangs()
    {
        return $this->hasMany(TourTypeLang::className(), ['tour_type_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\TourTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\TourTypeQuery(get_called_class());
    }
}
