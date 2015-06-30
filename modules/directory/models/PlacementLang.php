<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "placement_lang".
 *
 * @property integer $id
 * @property integer $placement_id
 * @property integer $lang_id
 * @property string $name
 *
 * @property Lang $lang
 * @property Placement $placement
 */
class PlacementLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'placement_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['placement_id', 'lang_id'], 'required'],
            [['placement_id', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'placement_id' => 'Placement ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
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
    public function getPlacement()
    {
        return $this->hasOne(Placement::className(), ['id' => 'placement_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\PlacementLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\PlacementLangQuery(get_called_class());
    }
}
