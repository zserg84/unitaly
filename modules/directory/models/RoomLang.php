<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "room_lang".
 *
 * @property integer $id
 * @property integer $room_id
 * @property integer $lang_id
 * @property string $desc_short
 * @property string $desc_full
 *
 * @property Lang $lang
 * @property Room $room
 */
class RoomLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_id', 'lang_id'], 'required'],
            [['room_id', 'lang_id'], 'integer'],
            [['desc_short', 'desc_full'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_id' => 'Room ID',
            'lang_id' => 'Lang ID',
            'desc_short' => 'Desc Short',
            'desc_full' => 'Desc Full',
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
    public function getRoom()
    {
        return $this->hasOne(Room::className(), ['id' => 'room_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\RoomLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\RoomLangQuery(get_called_class());
    }
}
