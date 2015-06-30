<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_121132_tour_schedule_lang extends Migration
{
    public function up()
    {
        $this->createTable('tour_schedule_lang', [
            'id' => 'pk',
            'tour_schedule_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'text' => Schema::TYPE_TEXT
        ]);
        $this->addForeignKey('fk_tour_schedule_lang_schedule_id__tour_schedule_id', 'tour_schedule_lang', 'tour_schedule_id', 'tour_schedule', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tour_schedule_lang_lang_id__lang_id', 'tour_schedule_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('tour_schedule_lang');
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
