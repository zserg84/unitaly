<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_053049_placement_options_id extends Migration
{
    public function up()
    {
	    $this->alterColumn('placement_option', 'identifier', 'varchar(20) not null comment "идентификатор опции размещения"');

    }

    public function down()
    {
	    $this->alterColumn('placement_option', 'identifier', Schema::TYPE_INTEGER .' NOT NULL COMMENT "Идентификатор опции размещения"');

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
