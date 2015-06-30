<?php

use yii\db\Schema;
use yii\db\Migration;

class m150610_101619_alter_placement_lat_lon extends Migration
{
    public function up()
    {
        $this->alterColumn('placement', 'latitude', Schema::TYPE_STRING);
        $this->alterColumn('placement', 'longitude', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->alterColumn('placement', 'latitude', Schema::TYPE_DECIMAL);
        $this->alterColumn('placement', 'longitude', Schema::TYPE_DECIMAL);
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
