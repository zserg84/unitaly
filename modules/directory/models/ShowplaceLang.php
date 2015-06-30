<?php

namespace modules\directory\models;

use Yii;

/**
 * This is the model class for table "showplace_lang".
 *
 * @property integer $id
 * @property integer $showplace_id
 * @property integer $lang_id
 * @property string $name
 * @property string $short_description
 * @property string $description
 *
 * @property Lang $lang
 * @property Showplace $showplace
 */
class ShowplaceLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'showplace_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['showplace_id', 'lang_id'], 'required'],
            [['showplace_id', 'lang_id'], 'integer'],
            [['short_description', 'description'], 'string'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('showplace_lang', 'ID'),
            'showplace_id' => Yii::t('showplace_lang', 'Showplace ID'),
            'lang_id' => Yii::t('showplace_lang', 'Lang ID'),
            'name' => Yii::t('showplace_lang', 'Name'),
            'short_description' => Yii::t('showplace_lang', 'Short Description'),
            'description' => Yii::t('showplace_lang', 'Description'),
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
    public function getShowplace()
    {
        return $this->hasOne(Showplace::className(), ['id' => 'showplace_id']);
    }

    /**
     * @inheritdoc
     * @return \modules\directory\models\query\ShowplaceLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \modules\directory\models\query\ShowplaceLangQuery(get_called_class());
    }
}
