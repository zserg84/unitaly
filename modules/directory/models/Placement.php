<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\image\models\Image;
use modules\translations\models\Lang;
use Yii;
use yii\base\Model;
use modules\base\behaviors\TranslateBehavior;

/**
 * This is the model class for table "placement".
 *
 * @property integer $id
 * @property integer $frontend
 * @property string $name
 * @property string $spellings
 * @property integer $placement_type_id
 * @property integer $placement_sub_type_id
 * @property string $placement_net
 * @property integer $rooms
 * @property string $cheap
 * @property string $expensive
 * @property integer $city_id
 * @property integer $logo_image_id
 * @property integer $add_image_id
 * @property string $address
 * @property string $main_phone
 * @property string $add_phone
 * @property string $fax
 * @property string $email
 * @property string $site
 * @property string $facebook
 * @property string $instagram
 * @property string $desc_short
 * @property string $desc_full
 * @property string $latitude
 * @property string $longitude
 * @property integer $hub_id
 * @property string $services
 * @property integer $identifier
 *
 * @property Cafe[] $caves
 * @property PlacementSubType $placementSubType
 * @property PlacementType $placementType
 * @property City $city
 * @property Hub $hub
 * @property PlacementLang[] $placementLangs
 */
class Placement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'placement';
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => PlacementLang::className(),
                'relationFieldName' => 'placement_id',
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
            [['frontend', 'placement_type_id', 'placement_sub_type_id', 'rooms', 
                'city_id', 'logo_image_id', 'add_image_id', 'hub_id', 'identifier'], 'integer'],
            [['name', 'spellings', 'placement_net', 'cheap', 'expensive', 'address', 
                'main_phone', 'add_phone', 'fax', 'email', 'site', 'facebook', 'instagram', 
                'desc_short', 'desc_full', 'services', 'latitude', 'longitude'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID места размещения',
            'frontend' => 'Вывод на фронт-енд',
            'name' => 'Название места размещения',
            'spellings' => 'Дополнительные варианты написания',
            'placement_type_id' => 'Тип места размещения',
            'placement_sub_type_id' => 'Подтип места размещения',
            'placement_net' => 'Принадлежность к сети',
            'rooms' => 'Количество номеров',
            'cheap' => 'Цена самого дешёвого номера (за сутки)',
            'expensive' => 'Цена самого дорогого номера (за сутки)',
            'city_id' => 'Принадлежность к городу',
            'logo_image_id' => 'Логотип места размещения',
            'add_image_id' => 'Дополнительное изображение места размещения',
            'address' => 'Адрес места размещения',
            'main_phone' => 'Основной телефон отеля',
            'add_phone' => 'Дополнительные телефоны',
            'fax' => 'Факс',
            'email' => 'Контактный e-mail',
            'site' => 'Официальный сайт',
            'facebook' => 'Aкк Facebook',
            'instagram' => 'Акк Instagram',
            'desc_short' => 'Краткое описание места размещения',
            'desc_full' => 'Подробное описание места размещения',
            'latitude' => 'Широта',
            'longitude' => 'Долгота',
            'hub_id' => 'Принадлежность к Хаб',
            'services' => 'Дополнительные услуги',
            'identifier' => 'Identifier',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaves()
    {
        return $this->hasMany(Cafe::className(), ['placement_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacementSubType()
    {
        return $this->hasOne(PlacementSubType::className(), ['id' => 'placement_sub_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacementType()
    {
        return $this->hasOne(PlacementType::className(), ['id' => 'placement_type_id']);
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
    public function getHub()
    {
        return $this->hasOne(Hub::className(), ['id' => 'hub_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacementLangs()
    {
        return $this->hasMany(PlacementLang::className(), ['placement_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\PlacementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\PlacementQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogoImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'logo_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'add_image_id']);
    }

}
