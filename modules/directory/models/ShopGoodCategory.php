<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "shop_good_category".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property integer $good_category_id
 *
 * @property GoodCategory $goodCategory
 * @property Shop $shop
 */
class ShopGoodCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_good_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'good_category_id'], 'required'],
            [['shop_id', 'good_category_id'], 'integer'],
            [['good_category_id', 'shop_id'], 'unique', 'targetAttribute' => ['good_category_id', 'shop_id'], 'message' => 'The combination of Shop ID and Good Category ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop_good_category', 'ID'),
            'shop_id' => Yii::t('shop_good_category', 'Shop ID'),
            'good_category_id' => Yii::t('shop_good_category', 'Good Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodCategory()
    {
        return $this->hasOne(GoodCategory::className(), ['id' => 'good_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShopGoodCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShopGoodCategoryQuery(get_called_class());
    }
}
