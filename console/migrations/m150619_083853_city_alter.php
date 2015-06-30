<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_083853_city_alter extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_city_region_id_region_id', 'city');
        $this->dropIndex('fk_city_region_id_region_id', 'city');
        $this->dropColumn('city', 'region_id');
        $this->addColumn('city', 'province_id', Schema::TYPE_INTEGER .' NOT NULL');
        $this->delete('city');
        $this->addForeignKey('fk_city_province_id_province_id', 'city', 'province_id', 'province', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m150619_083853_city_alter cannot be reverted.\n";

        return false;
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
