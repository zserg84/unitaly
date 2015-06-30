<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_091235_showplace_type_alter extends Migration
{
    public function up()
    {
        $this->addColumn('showplace_type', 'image_id', Schema::TYPE_INTEGER);
        $this->addForeignKey('showplace_type_image_id__image_id', 'showplace_type', 'image_id', 'image', 'id', 'SET NULL', 'SET NULL');
    }

    public function down()
    {
        $this->dropColumn('showplace_type', 'image_id');
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
