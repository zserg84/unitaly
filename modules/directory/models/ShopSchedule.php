<?php

namespace modules\directory\models;

use modules\base\behaviors\LangSaveBehavior;
use modules\base\behaviors\TranslateBehavior;
use Yii;

/**
 * This is the model class for table "shop_schedule".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property string $text
 * @property integer $date_from
 * @property integer $date_to
 *
 * @property Shop $shop
 * @property ShopScheduleLang[] $shopScheduleLangs
 */
class ShopSchedule extends \yii\db\ActiveRecord
{
    public static $langUrl = 'ru';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'text', 'date_from'], 'required'],
            [['shop_id', 'date_from', 'date_to'], 'integer'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop_schedule', 'ID'),
            'shop_id' => Yii::t('shop_schedule', 'Shop ID'),
            'text' => Yii::t('shop_schedule', 'Text'),
            'date_from' => Yii::t('shop_schedule', 'Date From'),
            'date_to' => Yii::t('shop_schedule', 'Date To'),
        ];
    }

    public function behaviors(){
        return [
            'langSave' => [
                'class' => LangSaveBehavior::className(),
            ],
            'translate' => [
                'class' => TranslateBehavior::className(),
                'translateModelName' => ShopScheduleLang::className(),
                'relationFieldName' => 'shop_schedule_id',
                'translateFieldNames' => ['text'],
                'langUrl' => self::$langUrl,
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopScheduleLangs()
    {
        return $this->hasMany(ShopScheduleLang::className(), ['shop_schedule_id' => 'id'])->indexBy('lang_id');;
    }

    public function beforeValidate(){
        $this->date_from = Yii::$app->getFormatter()->asTimestamp($this->date_from);
        $this->date_to = Yii::$app->getFormatter()->asTimestamp($this->date_to);
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShopScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShopScheduleQuery(get_called_class());
    }
}
