<?php

use yii\db\Schema;
use yii\db\Migration;

class m150615_124004_alter_additional_service_lang extends Migration
{
    public function up()
    {
        $this->addColumn('additional_service_lang', 'lang_id', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addForeignKey('fk_additional_service_lang_lang_id__lang_id', 'additional_service_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('additional_service_lang', 'lang_id');
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
