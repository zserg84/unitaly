<?php

namespace modules\directory\models;

use modules\directory\Module as DirectoryModule;
use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use Yii;

/**
 * This is the model class for table "province".
 *
 * @property integer $id
 * @property integer $region_id
 * @property integer $visit_image_id
 * @property integer $arms_image_id
 * @property integer $flag_image_id
 * @property integer $city_id
 *
 * @property City[] $cities
 * @property Image $flagImage
 * @property Image $armsImage
 * @property City $city
 * @property Region $region
 * @property Image $visitImage
 * @property ProvinceLang[] $provinceLangs
 */
class Province extends \yii\db\ActiveRecord
{
    public $name;
    public $spellings;
    public $description;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id'], 'required'],
            [['region_id', 'visit_image_id', 'arms_image_id', 'flag_image_id', 'city_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('province', 'IDENTIFIER'),
            'region_id' => DirectoryModule::t('province', 'REGION_ID'),
            'name' => DirectoryModule::t('province', 'NAME'),
            'spellings' => DirectoryModule::t('province', 'SPELLINGS'),
            'visit_image' => DirectoryModule::t('province', 'VISIT_IMAGE'),
            'flag_image' => DirectoryModule::t('province', 'FLAG_IMAGE'),
            'arms_image' => DirectoryModule::t('province', 'ARMS_IMAGE'),
            'city_id' => DirectoryModule::t('province', 'CITY'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => ProvinceLang::className(),
                'relationFieldName' => 'province_id',
                'translateFieldNames' => ['name'],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['province_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlagImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'flag_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArmsImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'arms_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'visit_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinceLangs()
    {
        return $this->hasMany(ProvinceLang::className(), ['province_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ProvinceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ProvinceQuery(get_called_class());
    }
}
