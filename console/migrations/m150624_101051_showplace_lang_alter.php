<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_101051_showplace_lang_alter extends Migration
{
    public function up()
    {
        $this->addColumn('showplace_lang', 'address', Schema::TYPE_STRING . '(255)');
        $this->addColumn('showplace_lang', 'short_description', Schema::TYPE_TEXT);
        $this->addColumn('showplace_lang', 'description', Schema::TYPE_TEXT);
    }

    public function down()
    {
        $this->dropColumn('showplace_lang', 'description');
        $this->dropColumn('showplace_lang', 'short_description');
        $this->dropColumn('showplace_lang', 'address');
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
