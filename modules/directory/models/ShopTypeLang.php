<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "shop_type_lang".
 *
 * @property integer $id
 * @property integer $shop_type_id
 * @property integer $lang_id
 * @property string $name
 * @property string $description
 *
 * @property Lang $lang
 * @property ShopType $shopType
 */
class ShopTypeLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_type_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_type_id', 'lang_id'], 'required'],
            [['shop_type_id', 'lang_id'], 'integer'],
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
            'id' => Yii::t('shop_type_lang', 'ID'),
            'shop_type_id' => Yii::t('shop_type_lang', 'Shop Type ID'),
            'lang_id' => Yii::t('shop_type_lang', 'Lang ID'),
            'name' => Yii::t('shop_type_lang', 'Name'),
            'description' => Yii::t('shop_type_lang', 'Description'),
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
    public function getShopType()
    {
        return $this->hasOne(ShopType::className(), ['id' => 'shop_type_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShopTypeLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShopTypeLangQuery(get_called_class());
    }
}
