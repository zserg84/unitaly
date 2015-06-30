<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "service_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category_id
 *
 * @property AdditionalService[] $additionalServices
 * @property ServiceCategory $category
 */
class ServiceType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'category_id'], 'required'],
            [['category_id'], 'integer'],
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
            'id' => Yii::t('service_type', 'ID'),
            'name' => Yii::t('service_type', 'Name'),
            'category_id' => Yii::t('service_type', 'Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalServices()
    {
        return $this->hasMany(AdditionalService::className(), ['service_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ServiceCategory::className(), ['id' => 'category_id']);
    }

	/**
	 * устанавливает шаблонные значения для единственных записей в категории
	 * @param $categoryModel \modules\directory\models\ServiceCategory
	 *
	 * @return $this
	 */
	public function setOneByCategory($categoryModel)
	{
		$this->setAttributes(
			[
				'name' => $categoryModel->name,
				'category_id' => $categoryModel->id,
			]
		);
		return $this;
	}

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ServiceTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ServiceTypeQuery(get_called_class());
    }
}
