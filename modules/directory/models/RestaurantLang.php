<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "restaurant_lang".
 *
 * @property integer $id
 * @property integer $restaurant_id
 * @property integer $lang_id
 * @property string $name
 * @property string $worktime
 *
 * @property Lang $lang
 * @property Restaurant $restaurant
 */
class RestaurantLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'restaurant_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['restaurant_id', 'lang_id'], 'integer'],
            [['worktime'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restaurant_id' => 'Restaurant ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
            'worktime' => 'Worktime',
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
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\RestaurantLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\RestaurantLangQuery(get_called_class());
    }
}
