<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_112543_manufacture_alter extends Migration
{
    public function up()
    {
        $this->addColumn('manufacture', 'restaurant_id', Schema::TYPE_INTEGER);
        $this->addColumn('manufacture', 'shop_id', Schema::TYPE_INTEGER);
        $this->addColumn('manufacture', 'showplace_id', Schema::TYPE_INTEGER);
        $this->addColumn('manufacture', 'placement_id', Schema::TYPE_INTEGER);

        $this->addForeignKey('manufacture_restaurant_id__restaurant_id', 'manufacture', 'restaurant_id', 'restaurant', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('manufacture_shop_id__shop_id', 'manufacture', 'shop_id', 'shop', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('manufacture_showplace_id__showplace_id', 'manufacture', 'showplace_id', 'showplace', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('manufacture_placement_id__placement_id', 'manufacture', 'placement_id', 'placement', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('manufacture_placement_id__placement_id', 'manufacture');
        $this->dropForeignKey('manufacture_showplace_id__showplace_id', 'manufacture');
        $this->dropForeignKey('manufacture_shop_id__shop_id', 'manufacture');
        $this->dropForeignKey('manufacture_restaurant_id__restaurant_id', 'manufacture');

        $this->dropColumn('manufacture', 'restaurant_id');
        $this->dropColumn('manufacture', 'shop_id');
        $this->dropColumn('manufacture', 'showplace_id');
        $this->dropColumn('manufacture', 'placement_id');
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
