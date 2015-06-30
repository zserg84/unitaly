<?php

use yii\db\Schema;
use yii\db\Migration;

class m150605_111251_tour_type_alter extends Migration
{
    public function up()
    {
        $this->addColumn('tour_type', 'identifier', Schema::TYPE_INTEGER .' NOT NULL AFTER id');
        $this->createIndex('uidx_tour_type_identifier', 'tour_type', 'identifier', true);
    }

    public function down()
    {
        $this->dropColumn('tour_type', 'identifier');
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
