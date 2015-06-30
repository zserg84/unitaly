<?php

use yii\db\Schema;
use yii\db\Migration;

class m150615_085443_region_flag extends Migration
{
    public function up()
    {
	    $this->addColumn('region', 'flag_image_id', 'int default null comment "флаг региона"');
	    $this->addForeignKey('fk_region_flag_image_id_image_id', 'region', 'visit_image_id', 'image', 'id', 'set null', 'set null');

    }

    public function down()
    {
	    $this->dropForeignKey('fk_region_flag_image_id_image_id', 'region');
	    $this->dropColumn('region', 'flag_image_id');
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
