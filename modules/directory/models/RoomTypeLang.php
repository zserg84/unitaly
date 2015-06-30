<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "room_type_lang".
 *
 * @property integer $id
 * @property integer $room_type_id
 * @property integer $lang_id
 * @property string $name
 * @property string $description
 *
 * @property Lang $lang
 * @property RoomType $roomType
 */
class RoomTypeLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room_type_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_type_id', 'lang_id'], 'required'],
            [['room_type_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('room_type_lang', 'ID'),
            'room_type_id' => Yii::t('room_type_lang', 'Room Type ID'),
            'lang_id' => Yii::t('room_type_lang', 'Lang ID'),
            'name' => Yii::t('room_type_lang', 'Name'),
            'description' => Yii::t('room_type_lang', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomType()
    {
        return $this->hasOne(RoomType::className(), ['id' => 'room_type_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\RoomTypeLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\RoomTypeLangQuery(get_called_class());
    }
}
