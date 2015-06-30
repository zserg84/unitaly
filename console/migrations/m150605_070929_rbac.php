<?php

use yii\db\Schema;
use yii\db\Migration;

class m150605_070929_rbac extends Migration
{
    public function up()
    {
        exec('php yii migrate --migrationPath=@yii/rbac/migrations/ --interactive=0');
        exec('php yii rbac/rbac/init');
        exec('php yii users/rbac/add');
        exec('php yii directory/rbac/add');
    }

    public function down()
    {
//        echo "m150605_070929_rbac cannot be reverted.\n";
//
//        return false;
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
