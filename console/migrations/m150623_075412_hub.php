<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_075412_hub extends Migration
{
    public function up()
    {
	    $this->dropColumn('hub', 'identifier');
	    $this->alterColumn('hub', 'description', 'text default null comment "описание хаба"');
	    $this->alterColumn('hub', 'name', Schema::TYPE_STRING . '(255) DEFAULT NULL');
	    $this->alterColumn('hub_lang', 'name', Schema::TYPE_STRING . '(100) DEFAULT NULL');
    }

    public function down()
    {
	    $this->addColumn('hub', 'identifier', 'varchar(20) not null comment "идентификатор"');
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
