<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use Yii;

/**
 * This is the model class for table "good_category".
 *
 * @property integer $id
 * @property integer $image_id
 *
 * @property Image $image
 * @property GoodCategoryLang[] $goodCategoryLangs
 * @property ShopGoodCategory[] $shopGoodCategories
 */
class GoodCategory extends \yii\db\ActiveRecord
{
    public $name;
    public $description;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'good_category';
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
            'id' => Yii::t('good_category', 'ID'),
            'image_id' => Yii::t('good_category', 'Image ID'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => GoodCategoryLang::className(),
                'relationFieldName' => 'good_category_id',
                'translateFieldNames' => ['name', 'description'],
            ],
        ];
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
    public function getGoodCategoryLangs()
    {
        return $this->hasMany(GoodCategoryLang::className(), ['good_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopGoodCategories()
    {
        return $this->hasMany(ShopGoodCategory::className(), ['good_category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\GoodCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\GoodCategoryQuery(get_called_class());
    }
}
