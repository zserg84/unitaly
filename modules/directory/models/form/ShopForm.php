<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 24.06.15
 * Time: 16:52
 */

namespace modules\directory\models\form;


use modules\directory\Module;
use yii\base\Model;

class ShopForm extends Model
{

    public $shop_type_id;

    public function rules(){
        return [
            [['shop_type_id'], 'required'],
        ];
    }

    public function attributeLabels(){
        return [
            'shop_type_id' => Module::t('shop', 'SHOP_TYPE_ID'),
        ];
    }
} 