<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_054131_good_category_lang_alter extends Migration
{
    public function up()
    {
        $this->addColumn('good_category_lang', 'lang_id', Schema::TYPE_INTEGER . ' NOT NULL AFTER good_category_id');
        $this->addForeignKey('good_category_lang_lang_id__lang_id', 'good_category_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('good_category_lang', 'lang_id');
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
