<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "cafe_service".
 *
 * @property integer $id
 * @property integer $cafe_id
 * @property integer $service_id
 * @property integer $active
 * @property string $price
 *
 * @property AdditionalService $service
 * @property Cafe $cafe
 */
class CafeService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cafe_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cafe_id', 'service_id'], 'required'],
            [['cafe_id', 'service_id', 'active'], 'integer'],
            [['price'], 'number'],
            [['cafe_id', 'service_id'], 'unique', 'targetAttribute' => ['cafe_id', 'service_id'], 'message' => 'The combination of Cafe ID and Service ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cafe_service', 'ID'),
            'cafe_id' => Yii::t('cafe_service', 'Cafe ID'),
            'service_id' => Yii::t('cafe_service', 'Service ID'),
            'active' => Yii::t('cafe_service', 'Active'),
            'price' => Yii::t('cafe_service', 'Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(AdditionalService::className(), ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCafe()
    {
        return $this->hasOne(Cafe::className(), ['id' => 'cafe_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\CafeServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\CafeServiceQuery(get_called_class());
    }
}
