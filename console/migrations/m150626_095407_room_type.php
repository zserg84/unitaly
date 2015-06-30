<?php

use yii\db\Schema;
use yii\db\Migration;

class m150626_095407_room_type extends Migration
{

    public function up()
    {
	    $this->createTable('room_type', [
		    'id' => 'pk',
		    'image_id' => Schema::TYPE_INTEGER,
	    ]);
	    $this->addForeignKey('room_type_image_id__image_id', 'room_type', 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');

    }

    public function down()
    {
	    $this->dropTable('room_type');
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
