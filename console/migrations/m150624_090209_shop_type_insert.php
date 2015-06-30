<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_090209_shop_type_insert extends Migration
{
    public function up()
    {
        $types = [
            'Аутлет', 'Молл', 'Гипер-супермаркет', 'Магазин', 'Рынок'
        ];
        foreach($types as $k=>$type){
            $this->insert('shop_type', [
                'id' => $k+1,
            ]);
            $this->insert('shop_type_lang', [
                'name' => $type,
                'shop_type_id' => $k+1,
                'lang_id' => 2
            ]);
        }
    }

    public function down()
    {
        $this->delete('shopt_type');
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
