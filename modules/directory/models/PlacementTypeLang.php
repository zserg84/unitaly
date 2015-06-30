<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "placement_type_lang".
 *
 * @property integer $id
 * @property integer $placement_type_id
 * @property integer $lang_id
 * @property string $name
 *
 * @property Lang $lang
 * @property PlacementType $placementType
 */
class PlacementTypeLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'placement_type_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['placement_type_id', 'lang_id'], 'required'],
            [['placement_type_id', 'lang_id'], 'integer'],
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
            'placement_type_id' => 'Placement Type ID',
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
    public function getPlacementType()
    {
        return $this->hasOne(PlacementType::className(), ['id' => 'placement_type_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\PlacementTypeLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\PlacementTypeLangQuery(get_called_class());
    }
}
