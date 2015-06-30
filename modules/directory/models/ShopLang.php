<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "shop_lang".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property integer $lang_id
 * @property string $name
 * @property string $spellings
 * @property string $worktime
 * @property string $short_description
 * @property string $description
 *
 * @property Lang $lang
 * @property Shop $shop
 */
class ShopLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'lang_id'], 'required'],
            [['shop_id', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['spellings'], 'string', 'max' => 255],
            [['worktime'], 'string', 'max' => 50],
            [['short_description', 'description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop_lang', 'ID'),
            'shop_id' => Yii::t('shop_lang', 'Shop ID'),
            'lang_id' => Yii::t('shop_lang', 'Lang ID'),
            'name' => Yii::t('shop_lang', 'Name'),
            'spellings' => Yii::t('shop_lang', 'Spellings'),
            'worktime' => Yii::t('shop_lang', 'Worktime'),
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
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShopLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShopLangQuery(get_called_class());
    }
}
