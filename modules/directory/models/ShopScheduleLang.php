<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "shop_schedule_lang".
 *
 * @property integer $id
 * @property integer $shop_schedule_id
 * @property integer $lang_id
 * @property string $text
 *
 * @property Lang $lang
 * @property ShopSchedule $shopSchedule
 */
class ShopScheduleLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_schedule_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_schedule_id', 'lang_id'], 'required'],
            [['shop_schedule_id', 'lang_id'], 'integer'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop_schedule_lang', 'ID'),
            'shop_schedule_id' => Yii::t('shop_schedule_lang', 'Shop Schedule ID'),
            'lang_id' => Yii::t('shop_schedule_lang', 'Lang ID'),
            'text' => Yii::t('shop_schedule_lang', 'Text'),
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
    public function getShopSchedule()
    {
        return $this->hasOne(ShopSchedule::className(), ['id' => 'shop_schedule_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShopScheduleLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShopScheduleLangQuery(get_called_class());
    }
}
