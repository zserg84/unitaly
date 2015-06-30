<?php

use yii\db\Schema;
use yii\db\Migration;

class m150611_080726_tour_schedule extends Migration
{
    public function up()
    {
        $this->createTable('tour_schedule', [
            'id' => 'pk',
            'tour_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL COMMENT "Текст расписания"',
            'date' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Дата"',
            'time_from' => Schema::TYPE_STRING . '(25) NOT NULL COMMENT "Время начала"',
            'time_to' => Schema::TYPE_STRING . '(25) COMMENT "Время окончания"',
        ]);
        $this->addForeignKey('fk_tour_schedule_tour_id__tour_id', 'tour_schedule', 'tour_id', 'tour', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_tour_schedule_date', 'tour_schedule', 'date');
    }

    public function down()
    {
        $this->dropTable('tour_schedule');
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
