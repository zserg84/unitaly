<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_110555_add_shop_category_to_shop extends Migration
{
    public function up()
    {
        $this->addColumn('shop', 'shop_category_id', Schema::TYPE_INTEGER . ' COMMENT "Категрия магазина"');
        $this->addForeignKey('fk_shop_shop_category_id__shop_category_id', 'shop', 'shop_category_id', 'shop_category', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('shop', 'shop_category_id');
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
