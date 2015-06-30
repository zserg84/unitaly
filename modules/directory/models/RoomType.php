<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use Yii;
use modules\directory\Module as DirectoryModule;

/**
 * This is the model class for table "room_type".
 *
 * @property integer $id
 * @property integer $image_id
 *
 * @property Room[] $rooms
 * @property Image $image
 * @property RoomTypeLang[] $roomTypeLangs
 */
class RoomType extends \yii\db\ActiveRecord
{
    public $name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('room_type', 'ID'),
            'image_id' => Yii::t('room_type', 'Image ID'),
            'name' => DirectoryModule::t('room-type', 'TRANSLATION_NAME'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => RoomTypeLang::className(),
                'relationFieldName' => 'room_type_id',
                'translateFieldNames' => ['name'],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasMany(Room::className(), ['room_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomCategories()
    {
        return $this->hasMany(RoomCategory::className(), ['room_type_id' => 'id']);
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
    public function getRoomTypeLangs()
    {
        return $this->hasMany(RoomTypeLang::className(), ['room_type_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\RoomTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\RoomTypeQuery(get_called_class());
    }
}
