<?php

use yii\db\Schema;
use yii\db\Migration;

class m150605_070506_alter_tour_type extends Migration
{
    public function up()
    {
        $this->dropTable('tour_type');
        $this->createTable('tour_type', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
            'image_id' => Schema::TYPE_INTEGER,
        ]);
        $this->addForeignKey('fk_tour_type_image_id__image_id', 'tour_type', 'image_id', 'image', 'id', 'SET NULL', 'SET NULL');

        $this->createTable('tour_type_lang', [
            'id' => 'pk',
            'tour_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('fk_tour_type_lang_tour_type_id__tour_type_id', 'tour_type_lang', 'tour_type_id', 'tour_type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tour_type_lang_lang_id__lang_id', 'tour_type_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        
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
