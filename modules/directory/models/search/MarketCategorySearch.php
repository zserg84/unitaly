<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.06.15
 * Time: 12:43
 */

namespace modules\directory\models\search;


use modules\directory\models\ShopType;

class MarketCategorySearch extends ShopCategorySearch
{
    protected  $_shop_type_id = ShopType::TYPE_MARKET;
} 