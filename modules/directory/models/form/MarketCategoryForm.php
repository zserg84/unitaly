<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.06.15
 * Time: 12:30
 */

namespace modules\directory\models\form;


use modules\directory\models\ShopType;

class MarketCategoryForm extends ShopCategoryForm
{

    public $shop_type_id = ShopType::TYPE_MARKET;
} 