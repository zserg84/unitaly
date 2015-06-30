<?php

use yii\db\Schema;
use yii\db\Migration;

class m150616_113258_placement_options extends Migration
{
    public function up()
    {
	    $this->createTable('placement_option', [
		    'id' => 'pk',
		    'identifier' => Schema::TYPE_INTEGER .' NOT NULL COMMENT "Идентификатор опции размещения"',
		    'name' => Schema::TYPE_STRING .' DEFAULT NULL COMMENT "Название"',
		    'description' => Schema::TYPE_TEXT.' DEFAULT NULL COMMENT "Описание"',
		    'image_id' => Schema::TYPE_INTEGER . ' COMMENT "Пинтограмма-изображение для опции"',
	    ]);
	    $this->createIndex('uidx_placement_option_identifier', 'placement_option', 'identifier', true);
	    $this->addForeignKey('fk_placement_option_image_id__image_id', 'placement_option', 'image_id', 'image', 'id', 'SET NULL', 'SET NULL');

    }

    public function down()
    {
	    $this->dropForeignKey('fk_placement_option_image_id__image_id', 'placement_option');
	    $this->dropIndex('uidx_placement_option_identifier', 'placement_option');
        $this->dropTable('placement_option');
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
