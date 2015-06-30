<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_063957_regions_alter extends Migration
{
    public function up()
    {
	    $this->alterColumn('region_lang', 'name', 'varchar(100) DEFAULT NULL');
	    $this->alterColumn('city_lang', 'name', 'varchar(100) DEFAULT NULL');
    }

    public function down()
    {
        echo "m150619_063957_regions_alter cannot be reverted.\n";

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
