<?php

namespace modules\directory\models\form;

use modules\base\behaviors\ImageBehavior;
use modules\directory\models\Room;
use modules\image\models\Image;
use yii\base\Model;
use modules\directory\Module as DirectoryModule;
use modules\base\validators\EachValidator;
use modules\base\validators\LangRequiredValidator;
use modules\base\validators\LangUniqueValidator;
use modules\directory\models\RoomLang;

class RoomForm extends Model
{
    public $id;
    public $active;
    public $building;
    public $room_type_id;
    public $area;
    public $bed;
    public $capacity;
    public $price;
    public $time;
    public $main_image;
    public $add_image;
    public $desc_short;
    public $desc_full;
    public $desc_short_translate;
    public $desc_full_translate;
    public $placement_id;
    public $main_image_id;
    public $add_image_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'placement_id', 'building', 'room_type_id', 'area',
                'bed',  'capacity', 'price', 'desc_short_translate'], 'required'],
            [['active', 'placement_id', 'room_type_id', 'main_image_id', 'add_image_id'], 'integer'],
            [['building', 'area', 'bed', 'capacity', 'price', 'time'], 'string', 'max' => 255],
            [['main_image', 'add_image'], 'file', 'mimeTypes'=> ['image/png', 'image/jpeg', 'image/gif'], 'wrongMimeType'=>DirectoryModule::t('themes-admin', 'IMAGE_MESSAGE_FILE_TYPES').' jpg, png, gif'],
            ['desc_short_translate', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['desc_short_translate', LangRequiredValidator::className()],
            ['desc_full_translate', EachValidator::className(), 'rule'=>['string', 'max'=>50]],
            ['desc_full_translate', LangRequiredValidator::className()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'active' => DirectoryModule::t('room', 'ACTIVE'),
            'building' => DirectoryModule::t('room', 'BUILDING'),
            'room_type_id' => DirectoryModule::t('room', 'ROOM_TYPE'),
            'area' => DirectoryModule::t('room', 'AREA'),
            'bed' => DirectoryModule::t('room', 'BED'),
            'capacity' => DirectoryModule::t('room', 'CAPACITY'),
            'price' => DirectoryModule::t('room', 'PRICE'),
            'time' => DirectoryModule::t('room', 'TIME'),
            'main_image' => DirectoryModule::t('room', 'MAIN_IMAGE'),
            'add_image' => DirectoryModule::t('room', 'ADD_IMAGE'),
            'desc_short_translate' => DirectoryModule::t('room', 'DESC_SHORT'),
            'desc_full_translate' => DirectoryModule::t('room', 'DESC_FULL'),
            'placement_id' => DirectoryModule::t('room', 'HOTEL'),
        ];
    }

    public function behaviors()
    {
        return [
            'imageBehavior' => [
                'class' => ImageBehavior::className(),
            ]
        ];
    }

}
