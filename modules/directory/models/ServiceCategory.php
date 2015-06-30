<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "service_category".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ServiceType[] $serviceTypes
 */
class ServiceCategory extends \yii\db\ActiveRecord
{

    const CATEGORY_ROOM = 1;
    const CATEGORY_HOTEL = 2;
    const CATEGORY_TOUR = 3;
    const CATEGORY_CAFE = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_category';
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
            'id' => Yii::t('service_category', 'ID'),
            'name' => Yii::t('service_category', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceTypes()
    {
        return $this->hasMany(ServiceType::className(), ['category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ServiceCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ServiceCategoryQuery(get_called_class());
    }
}
