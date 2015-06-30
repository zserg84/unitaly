<?php

namespace modules\directory\models;

use modules\translations\models\Lang;
use Yii;

/**
 * This is the model class for table "showplace_type_lang".
 *
 * @property integer $id
 * @property integer $showplace_type_id
 * @property integer $lang_id
 * @property string $name
 * @property string $description
 *
 * @property Lang $lang
 * @property ShowplaceType $showplaceType
 */
class ShowplaceTypeLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'showplace_type_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['showplace_type_id', 'lang_id'], 'required'],
            [['showplace_type_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('showplace_type_lang', 'ID'),
            'showplace_type_id' => Yii::t('showplace_type_lang', 'Showplace Type ID'),
            'lang_id' => Yii::t('showplace_type_lang', 'Lang ID'),
            'name' => Yii::t('showplace_type_lang', 'Name'),
            'description' => Yii::t('showplace_type_lang', 'Description'),
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
    public function getShowplaceType()
    {
        return $this->hasOne(ShowplaceType::className(), ['id' => 'showplace_type_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShowplaceTypeLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShowplaceTypeLangQuery(get_called_class());
    }
}
