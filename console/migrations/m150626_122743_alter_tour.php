<?php

use yii\db\Schema;
use yii\db\Migration;

class m150626_122743_alter_tour extends Migration
{
    public function up()
    {
        $this->renameColumn('tour', 'visible', 'frontend');
    }

    public function down()
    {
        $this->renameColumn('tour', 'frontend', 'visible');
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
