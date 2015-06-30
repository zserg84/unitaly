<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_081152_showplacetype_lang extends Migration
{
    public function up()
    {
        $this->createTable('showplace_type_lang', [
            'id' => 'pk',
            'showplace_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('fk_showplace_type_lang_showplace__type_id__showplace_type_id', 'showplace_type_lang', 'showplace_type_id', 'showplace_type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_showplace_type_lang_lang_id__lang_id', 'showplace_type_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('showplace_type_lang');
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
