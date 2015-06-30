<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_103620_showplace_alter extends Migration
{
    public function up()
    {
        $this->dropColumn('showplace', 'address');
        $this->dropColumn('showplace', 'short_description');
        $this->dropColumn('showplace', 'description');
    }

    public function down()
    {
        echo "m150624_103620_showplace_alter cannot be reverted.\n";

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
