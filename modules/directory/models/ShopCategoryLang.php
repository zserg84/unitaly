<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "shop_category_lang".
 *
 * @property integer $id
 * @property integer $shop_category_id
 * @property integer $lang_id
 * @property string $name
 * @property string $description
 *
 * @property Lang $lang
 * @property ShopCategory $shopCategory
 */
class ShopCategoryLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_category_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_category_id', 'lang_id'], 'required'],
            [['shop_category_id', 'lang_id'], 'integer'],
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
            'id' => Yii::t('shop_category_lang', 'ID'),
            'shop_category_id' => Yii::t('shop_category_lang', 'Shop Category ID'),
            'lang_id' => Yii::t('shop_category_lang', 'Lang ID'),
            'name' => Yii::t('shop_category_lang', 'Name'),
            'description' => Yii::t('shop_category_lang', 'Description'),
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
    public function getShopCategory()
    {
        return $this->hasOne(ShopCategory::className(), ['id' => 'shop_category_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShopCategoryLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShopCategoryLangQuery(get_called_class());
    }
}
