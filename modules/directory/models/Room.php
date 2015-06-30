<?php

namespace modules\directory\models;

use Yii;
use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use modules\translations\models\Lang;
use yii\helpers\ArrayHelper;
use modules\directory\models;

/**
 * This is the model class for table "room".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $placement_id
 * @property string $building
 * @property integer $room_type_id
 * @property string $area
 * @property string $bed
 * @property string $capacity
 * @property string $price
 * @property string $time
 * @property integer $main_image_id
 * @property integer $add_image_id
 * @property string $desc_short
 * @property string $desc_full
 *
 * @property Placement $placement
 * @property RoomLang[] $roomLangs
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'placement_id', 'room_type_id', 'main_image_id', 'add_image_id'], 'integer'],
            [['building', 'area', 'bed', 'capacity', 'price', 'time', 'desc_short', 'desc_full'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID Номера',
            'active' => 'Номер активен',
            'placement_id' => 'Принадлежность к отелю',
            'building' => 'Принадлежность к строению',
            'room_type_id' => 'Тип номера',
            'area' => 'Площадь номера, кв.м.',
            'bed' => 'Число кроватей, взрослых',
            'capacity' => 'Вместимость, максимальная',
            'price' => 'Цена за сутки',
            'time' => 'Время заселения/выселения',
            'main_image_id' => 'Основное изображение места размещения',
            'add_image_id' => 'Дополнительное изображение места размещения',
            'desc_short' => 'Краткое описание номера',
            'desc_full' => 'Подробное описание номера',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacement()
    {
        return $this->hasOne(Placement::className(), ['id' => 'placement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomLangs()
    {
        return $this->hasMany(RoomLang::className(), ['room_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\RoomQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\RoomQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMainImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'main_image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'add_image_id']);
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => RoomLang::className(),
                'relationFieldName' => 'room_id',
                'translateFieldNames' => ['desc_short', 'desc_full'],
            ],
        ];
    }
}
