<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_085850_shop_add_shoptype extends Migration
{
    public function up()
    {
        $this->addColumn('shop', 'shop_type_id', Schema::TYPE_INTEGER . ' NOT NULL AFTER id');
        $this->addForeignKey('fk_shop_shop_type_id__shop_type_id', 'shop', 'shop_type_id', 'shop_type', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('shop', 'shop_type_id');
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
