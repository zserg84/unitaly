<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_062626_identifierdelete extends Migration
{
    public function up()
    {
        $this->dropColumn('showplace', 'identifier');
        $this->dropColumn('showplace_type', 'identifier');
        $this->dropColumn('tour', 'identifier');
        $this->dropColumn('tour_type', 'identifier');
    }

    public function down()
    {
        echo "m150619_062626_identifierdelete cannot be reverted.\n";

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
