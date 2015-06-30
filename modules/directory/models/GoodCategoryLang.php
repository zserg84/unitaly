<?php

namespace modules\directory\models;

use modules\translations\models\Lang;
use Yii;

/**
 * This is the model class for table "good_category_lang".
 *
 * @property integer $id
 * @property integer $good_category_id
 * @property integer $lang_id
 * @property string $name
 * @property string $description
 *
 * @property Lang $lang
 * @property GoodCategory $goodCategory
 */
class GoodCategoryLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'good_category_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['good_category_id', 'lang_id'], 'required'],
            [['good_category_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['good_category_id', 'name'], 'unique', 'targetAttribute' => ['good_category_id', 'name'], 'message' => 'The combination of Good Category ID and Name has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('good_category_lang', 'ID'),
            'good_category_id' => Yii::t('good_category_lang', 'Good Category ID'),
            'lang_id' => Yii::t('good_category_lang', 'Lang ID'),
            'name' => Yii::t('good_category_lang', 'Name'),
            'description' => Yii::t('good_category_lang', 'Description'),
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
    public function getGoodCategory()
    {
        return $this->hasOne(GoodCategory::className(), ['id' => 'good_category_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\GoodCategoryLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\GoodCategoryLangQuery(get_called_class());
    }
}
