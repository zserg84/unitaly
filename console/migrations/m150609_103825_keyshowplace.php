<?php

use yii\db\Schema;
use yii\db\Migration;

class m150609_103825_keyshowplace extends Migration
{
    public function up()
    {
	    $this->addColumn('showplace', 'main', Schema::TYPE_BOOLEAN . ' COMMENT "Ключевая достопримечательность"');
    }

    public function down()
    {
	    $this->dropColumn('showplace', 'main');
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
