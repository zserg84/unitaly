<?php

use yii\db\Schema;
use yii\db\Migration;

class m150610_111712_tour_alter extends Migration
{
    public function up()
    {
        $this->addColumn('tour', 'visible', Schema::TYPE_INTEGER . ' DEFAULT 0 COMMENT "Демонстрация тура на сайте"');
    }

    public function down()
    {
        $this->dropColumn('tour', 'visible');
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
