<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "hub_lang".
 *
 * @property integer $id
 * @property integer $hub_id
 * @property integer $lang_id
 * @property string $name
 * @property string $description
 *
 * @property Lang $lang
 * @property Hub $hub
 */
class HubLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hub_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hub_id', 'lang_id'], 'required'],
            [['hub_id', 'lang_id'], 'integer'],
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
            'id' => Yii::t('app', 'ID'),
            'hub_id' => Yii::t('app', 'Hub ID'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
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
    public function getHub()
    {
        return $this->hasOne(Hub::className(), ['id' => 'hub_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\HubLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\HubLangQuery(get_called_class());
    }
}
