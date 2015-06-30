<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 24.06.15
 * Time: 16:20
 */

namespace modules\directory\models\form;


use modules\base\validators\LangRequiredValidator;
use modules\directory\models\ShopType;
use modules\themes\Module as ThemeModule;

class ShopSupermarketForm extends ShopBaseForm
{
	public $shop_type_id = ShopType::TYPE_SUPERMARKET;

    public function rules()
    {
        $rules = parent::rules();
        return array_merge($rules, [
            [['region_id', 'province_id', 'city_id', 'address', 'latitude', 'longitude', 'categories'], 'required'],
            [['region_id', 'province_id', 'city_id'], 'integer'],
            [['translationName'], LangRequiredValidator::className(), 'langUrls'=>ThemeModule::getSystemLanguage()],
        ]);
    }
} 