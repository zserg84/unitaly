<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use modules\translations\models\Lang;
use Yii;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;

/**
 * This is the model class for table "showplace".
 *
 * @property integer $id
 * @property string $name
 * @property string $org_service_provider
 * @property integer $showplace_type_id
 * @property integer $city_id
 * @property integer $image_id
 * @property integer $additional_image_id
 * @property string $latitude
 * @property string $longitude
 * @property string $representative_name
 * @property string $representative_phone
 * @property string $representative_email
 * @property string $site
 * @property string $facebook
 * @property string $instagram
 * @property double $price_adult
 * @property double $price_child
 * @property string $schedule
 * @property integer $has_excursion
 * @property double $price_excursion_guide_group
 * @property double $price_excursion_guide_individual
 * @property double $price_excursion_guide_audio
 * @property string $additional
 * @property integer $main
 *
 * @property City $city
 * @property Image $additionalImage
 * @property Image $image
 * @property ShowplaceType $showplaceType
 * @property ShowplaceLang[] $showplaceLangs
 */
class Showplace extends \yii\db\ActiveRecord
{

    public $name;
    public $short_description;
    public $description;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'showplace';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['showplace_type_id', 'city_id'], 'required'],
            [['showplace_type_id', 'city_id', 'image_id', 'additional_image_id', 'has_excursion', 'main'], 'integer'],
            [['org_service_provider', 'additional'], 'string'],
            [['price_adult', 'price_child', 'price_excursion_guide_group', 'price_excursion_guide_individual', 'price_excursion_guide_audio'], 'number'],
            [['name', 'address', 'latitude', 'longitude', 'representative_name', 'representative_phone', 'site', 'facebook', 'instagram', 'schedule'], 'string', 'max' => 255],
            [['representative_email'], 'string', 'max' => 50],
            [['representative_email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => DirectoryModule::t('showplace', 'NAME'),
            'org_service_provider' => DirectoryModule::t('showplace', 'ORG_SERVICE_PROVIDER'),
            'showplace_type_id' => DirectoryModule::t('showplace', 'SHOWPLACE_TYPE_ID'),
            'city_id' => DirectoryModule::t('showplace', 'CITY_ID'),
            'region_id' => DirectoryModule::t('showplace', 'REGION_ID'),
            'address' => DirectoryModule::t('showplace', 'ADDRESS'),
            'image_id' => DirectoryModule::t('showplace', 'IMAGE_ID'),
            'additional_image_id' => DirectoryModule::t('showplace', 'ADDITIONAL_IMAGE_ID'),
            'latitude' => DirectoryModule::t('showplace', 'LATITUDE'),
            'longitude' => DirectoryModule::t('showplace', 'LONGITUDE'),
            'short_description' => DirectoryModule::t('showplace', 'SHORT_DESCRIPTION'),
            'description' => DirectoryModule::t('showplace', 'DESCRIPTION'),
            'representative_name' => DirectoryModule::t('showplace', 'REPRESENTATIVE_NAME'),
            'representative_phone' => DirectoryModule::t('showplace', 'REPRESENTATIVE_PHONE'),
            'representative_email' => DirectoryModule::t('showplace', 'REPRESENTATIVE_EMAIL'),
            'site' => DirectoryModule::t('showplace', 'SITE'),
            'facebook' => DirectoryModule::t('showplace', 'FACEBOOK'),
            'instagram' => DirectoryModule::t('showplace', 'INSTAGRAM'),
            'price' => DirectoryModule::t('showplace', 'PRICE'),
            'price_adult' => DirectoryModule::t('showplace', 'PRICE_ADULT'),
            'price_child' => DirectoryModule::t('showplace', 'PRICE_CHILD'),
            'schedule' => DirectoryModule::t('showplace', 'SCHEDULE'),
            'has_excursion' => DirectoryModule::t('showplace', 'HAS_EXCURSION'),
            'price_excursion_guide_group' => DirectoryModule::t('showplace', 'PRICE_EXCURSION_GUIDE_GROUP'),
            'price_excursion_guide_individual' => DirectoryModule::t('showplace', 'PRICE_EXCURSION_GUIDE_INDIVIDUAL'),
            'price_excursion_guide_audio' => DirectoryModule::t('showplace', 'PRICE_EXCURSION_GUIDE_AUDIO'),
            'additional' => DirectoryModule::t('showplace', 'ADDITIONAL'),
            'translationName' => DirectoryModule::t('showplace', 'TRANSLATION_NAME'),
            'main' => DirectoryModule::t('showplace', 'MAIN'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => ShowplaceLang::className(),
                'relationFieldName' => 'showplace_id',
                'translateFieldNames' => ['name', 'short_description', 'description'],
            ],
        ];
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
    public function getAdditionalImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'additional_image_id']);
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
    public function getShowplaceType()
    {
        return $this->hasOne(ShowplaceType::className(), ['id' => 'showplace_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShowplaceLangs()
    {
        return $this->hasMany(ShowplaceLang::className(), ['showplace_id' => 'id'])->indexBy('lang_id');
    }

	/**
	 * устанавливает ключевые достопримечательности в городе
	 * @param $city_id int id города
	 * @param array $ids массив идешников достопримечательностей
	 */
	public static function setToMain($city_id, $ids = []){
		if (!empty($ids)) {
			$ids = array_map(function($v){return (int) $v;}, $ids);
		}
		self::updateAll(['main' => 0], 'city_id = :city' . ((!empty($ids)) ? ' and id not in (' . implode(',', $ids) . ')' : ''), ['city' => $city_id]);
		if (!empty($ids)) self::updateAll(['main' => 1], 'city_id = :city and id in (' . implode(',', $ids) . ')', ['city' => $city_id]);
	}

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShowplaceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShowplaceQuery(get_called_class());
    }

}
