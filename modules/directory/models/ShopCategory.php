<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use Yii;
use modules\directory\Module as DirectoryModule;

/**
 * This is the model class for table "shop_category".
 *
 * @property integer $id
 * @property integer $image_id
 * @property integer $shop_type_id
 *
 * @property Shop[] $shops
 * @property Image $image
 * @property ShopType $shopType
 * @property ShopCategoryLang[] $shopCategoryLangs
 */
class ShopCategory extends \yii\db\ActiveRecord
{
    public $name;
    public $description;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_id', 'shop_type_id'], 'integer']
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => ShopCategoryLang::className(),
                'relationFieldName' => 'shop_category_id',
                'translateFieldNames' => ['name', 'description'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => DirectoryModule::t('shop-category', 'IDENTIFIER'),
            'name' => DirectoryModule::t('shop-category', 'TRANSLATION_NAME'),
            'description' => DirectoryModule::t('shop-category', 'TRANSLATION_DESCRIPTION'),
            'image' => DirectoryModule::t('shop-category', 'IMAGE'),
            'shop_type_id' => DirectoryModule::t('category', 'SHOP_TYPE_ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShops()
    {
        return $this->hasMany(Shop::className(), ['shop_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopType()
    {
        return $this->hasOne(ShopType::className(), ['id' => 'shop_type_id']);
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
    public function getShopCategoryLangs()
    {
        return $this->hasMany(ShopCategoryLang::className(), ['shop_category_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShopCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShopCategoryQuery(get_called_class());
    }
}
