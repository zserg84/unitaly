<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_114459_shop_schedule_lang extends Migration
{
    public function up()
    {
        $this->createTable('shop_schedule_lang', [
            'id' => 'pk',
            'shop_schedule_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'text' => Schema::TYPE_TEXT
        ]);
        $this->addForeignKey('fk_shop_schedule_lang_schedule_id__shop_schedule_id', 'shop_schedule_lang', 'shop_schedule_id', 'shop_schedule', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_shop_schedule_lang_lang_id__lang_id', 'shop_schedule_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('shop_schedule_lang');
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
