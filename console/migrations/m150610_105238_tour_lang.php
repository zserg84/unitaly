<?php

use yii\db\Schema;
use yii\db\Migration;

class m150610_105238_tour_lang extends Migration
{
    public function up()
    {
        $this->createTable('tour_lang', [
            'id' => 'pk',
            'tour_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING,
        ]);
        $this->addForeignKey('fk_tour_lang_tour_id__tour_id', 'tour_lang', 'tour_id', 'tour', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tour_lang_lang_id__lang_id', 'tour_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_tour_lang_tour_lang_name', 'tour_lang', 'tour_id, lang_id, name');
    }

    public function down()
    {
        $this->dropTable('tour_lang');
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
