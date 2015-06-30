<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.06.15
 * Time: 10:51
 */

namespace modules\directory\models\form;

use modules\directory\models\ShopType;
use modules\directory\Module as DirectoryModule;
use modules\base\validators\LangRequiredValidator;
use modules\themes\Module as ThemeModule;

class ShopMarketForm extends ShopBaseForm
{
    public $shop_category_id;
    public $shop_type_id = ShopType::TYPE_MARKET;

    public function rules()
    {
        $rules = parent::rules();
        return array_merge($rules, [
            [['region_id', 'province_id', 'city_id', 'address','latitude', 'longitude', 'categories', 'shop_category_id'], 'required'],
            [['region_id', 'province_id', 'city_id', 'shop_category_id'], 'integer'],
            [['translationName'], LangRequiredValidator::className(), 'langUrls'=>ThemeModule::getSystemLanguage()],
        ]);
    }

    public function attributeLabels(){
        $labels = parent::attributeLabels();
        return array_merge($labels,
            [
                'shop_category_id' => DirectoryModule::t('shop', 'SHOP_CATEGORY_ID'),
            ]
        );
    }
} 