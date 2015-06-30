<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "tour_offer_type".
 *
 * @property integer $id
 * @property string $name
 */
class TourOfferType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tour_offer_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tour_offer_type', 'ID'),
            'name' => Yii::t('tour_offer_type', 'Name'),
        ];
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\TourOfferTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\TourOfferTypeQuery(get_called_class());
    }
}
