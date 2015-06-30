<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_114200_shop_schedule extends Migration
{
    public function up()
    {
        $this->createTable('shop_schedule', [
            'id' => 'pk',
            'shop_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL COMMENT "Текст сезонности распродаж"',
            'date_from' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Дата начала"',
            'date_to' => Schema::TYPE_INTEGER . ' COMMENT "Дата окончания"',
        ], ' COMMENT "Сезонность распродаж"');
        $this->addForeignKey('fk_shop_schedule_shop_id__shop_id', 'shop_schedule', 'shop_id', 'shop', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_shop_schedule_date_from', 'shop_schedule', 'date_from');
        $this->createIndex('idx_shop_schedule_date_to', 'shop_schedule', 'date_to');
    }

    public function down()
    {
       $this->dropTable('shop_schedule');
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
