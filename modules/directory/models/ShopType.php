<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use modules\image\models\Image;
use Yii;
use modules\directory\Module as DirectoryModule;

/**
 * This is the model class for table "shop_type".
 *
 * @property integer $id
 * @property integer $image_id
 *
 * @property Shop[] $shops
 * @property ShopCategory[] $shopCategories
 * @property Image $image
 * @property ShopTypeLang[] $shopTypeLangs
 */
class ShopType extends \yii\db\ActiveRecord
{
    const TYPE_OUTLET = 1;          //  аутлет
    const TYPE_MALL = 2;            //  молл
    const TYPE_SUPERMARKET = 3;     //  супермаркет
    const TYPE_STORE = 4;           //  магазин
    const TYPE_MARKET = 5;          //  рынок

    public $name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_type';
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
            'id' => Yii::t('shop_type', 'ID'),
            'image_id' => Yii::t('shop_type', 'Image ID'),
            'name' => DirectoryModule::t('shop-type', 'TRANSLATION_NAME'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => ShopTypeLang::className(),
                'relationFieldName' => 'shop_type_id',
                'translateFieldNames' => ['name'],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShops()
    {
        return $this->hasMany(Shop::className(), ['shop_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopCategories()
    {
        return $this->hasMany(ShopCategory::className(), ['shop_type_id' => 'id']);
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
    public function getShopTypeLangs()
    {
        return $this->hasMany(ShopTypeLang::className(), ['shop_type_id' => 'id'])->indexBy('lang_id');
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShopTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShopTypeQuery(get_called_class());
    }
}
