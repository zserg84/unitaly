<?php

use yii\db\Schema;
use yii\db\Migration;

class m150616_080303_tour_service_alter extends Migration
{
    public function up()
    {
        $this->renameColumn('tour_service', 'active', 'include');
        $this->addColumn('tour_service', 'active', Schema::TYPE_BOOLEAN . ' DEFAULT 0 COMMENT "Наличие опции в туре"');
    }

    public function down()
    {
        $this->dropColumn('tour_service', 'active');
        $this->renameColumn('tour_service', 'include', 'active');
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
