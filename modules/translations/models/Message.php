<?php

namespace modules\translations\models;

use modules\translations\models\Lang;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use modules\translations\Module as TranslationModule;

class Message extends ActiveRecord
{
    /**
     * @return string
     * @throws InvalidConfigException
     */
    public static function tableName()
    {
        $i18n = Yii::$app->getI18n();
        if (!isset($i18n->messageTable)) {
            throw new InvalidConfigException('You should configure i18n component');
        }
        return $i18n->messageTable;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'source_message_id'], 'required'],
            ['translation', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => TranslationModule::t('translations', 'ID'),
            'lang_id' => TranslationModule::t('translations', 'LANGUAGE'),
            'translation' => TranslationModule::t('translations', 'TRANSLATIONS')
        ];
    }

    public function getSourceMessage()
    {
        return $this->hasOne(SourceMessage::className(), ['id' => 'source_message_id']);
    }

    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }
}
