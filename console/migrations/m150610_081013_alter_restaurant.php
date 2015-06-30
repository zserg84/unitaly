<?php

use yii\db\Schema;
use yii\db\Migration;

class m150610_081013_alter_restaurant extends Migration
{
    public function up()
    {
        $this->alterColumn('restaurant', 'latitude', Schema::TYPE_STRING);
        $this->alterColumn('restaurant', 'longitude', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->alterColumn('restaurant', 'latitude', Schema::TYPE_DECIMAL);
        $this->alterColumn('restaurant', 'longitude', Schema::TYPE_DECIMAL);
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
