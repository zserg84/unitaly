<?php

use yii\db\Schema;
use yii\db\Migration;

class m150605_090220_cityalter extends Migration
{
    public function up()
    {
	    $this->alterColumn('city', 'name', 'varchar(50) default null comment "наименование города"');
	    $this->alterColumn('city', 'description', 'text default null comment "описание"');
	    $this->alterColumn('region', 'name', 'varchar(50) default null comment "наименование города"');
	    $this->alterColumn('region', 'description', 'text default null comment "описание"');
    }

    public function down()
    {
        echo "m150605_090220_cityalter cannot be reverted.\n";

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
