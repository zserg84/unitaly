<?php

use yii\db\Schema;
use yii\db\Migration;

class m150626_072038_shop_category_type extends Migration
{
    public function up()
    {
        $this->addColumn('shop_category', 'shop_type_id', Schema::TYPE_INTEGER . ' DEFAULT NULL');
        $this->addForeignKey('fk_shop_category_shop_type_id__shop_type_id', 'shop_category', 'shop_type_id', 'shop_type', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('shop_category', 'shop_type_id');
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
