<?php

use yii\db\Schema;
use yii\db\Migration;

class m150602_073405_translate_messages extends Migration
{
    public function up()
    {
        $this->createTable('lang', [
            'id' => 'pk',
            'url' => Schema::TYPE_STRING . '(5) NOT NULL',
            'local' => Schema::TYPE_STRING . '(10) NOT NULL',
            'name' => Schema::TYPE_STRING . '(25) NOT NULL',
            'default' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createTable('message_category', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . '(32)',
        ]);

        $this->createTable('source_message', [
            'id' => 'pk',
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'message' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('source_message_category_id__message_category_id', 'source_message', 'category_id', 'message_category', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('message', [
            'id' => 'pk',
            'source_message_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'translation' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('message_source_message_id__source_message_id', 'message', 'source_message_id', 'source_message', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('message_lang_id__lang_id', 'message', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('message');
        $this->dropTable('source_message');
        $this->dropTable('message_category');
        $this->dropTable('lang');
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
