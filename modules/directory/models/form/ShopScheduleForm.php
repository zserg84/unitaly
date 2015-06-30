<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 25.06.15
 * Time: 17:09
 */

namespace modules\directory\models\form;

use modules\directory\Module as DirectoryModule;
use yii\base\Model;

class ShopScheduleForm extends Model
{
    public $date_from;
    public $date_to;
    public $text;
    public $shopId;
    public $translationText;

    public function rules()
    {
        return [
            [['text', 'date_from'], 'required'],
            [['text'], 'string'],
            [['date_from', 'date_to', 'text'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text' => DirectoryModule::t('shop-schedule', 'TEXT'),
            'date_from' => DirectoryModule::t('shop-schedule', 'DATE_FROM'),
            'date_to' => DirectoryModule::t('shop-schedule', 'DATE_TO'),
        ];
    }
} 