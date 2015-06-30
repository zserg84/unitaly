<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "tour_service".
 *
 * @property integer $id
 * @property integer $tour_id
 * @property integer $service_id
 * @property integer $include
 * @property string $price
 * @property integer $active
 *
 * @property AdditionalService $service
 * @property Tour $tour
 */
class TourService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tour_id', 'service_id'], 'required'],
            [['tour_id', 'service_id', 'include', 'active'], 'integer'],
            [['price'], 'number'],
            [['price', 'include'], 'safe'],
            [['tour_id', 'service_id'], 'unique', 'targetAttribute' => ['tour_id', 'service_id'], 'message' => 'The combination of Tour ID and Service ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tour_service', 'ID'),
            'tour_id' => Yii::t('tour_service', 'Tour ID'),
            'service_id' => Yii::t('tour_service', 'Service ID'),
            'active' => Yii::t('tour_service', 'Active'),
            'price' => Yii::t('tour_service', 'Price'),
            'include' => Yii::t('tour_service', 'Include'),
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
    public function getTour()
    {
        return $this->hasOne(Tour::className(), ['id' => 'tour_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\TourServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\TourServiceQuery(get_called_class());
    }
}
