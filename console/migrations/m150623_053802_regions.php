<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_053802_regions extends Migration
{
    public function up()
    {
	    $this->dropColumn('region', 'identifier');
	    $this->dropColumn('city', 'identifier');
	    $this->dropForeignKey('fk_region_flag_image_id_image_id', 'region');
	    $this->dropForeignKey('fk_region_visit_image_id_image_id', 'region');
	    $this->dropForeignKey('fk_region_arms_image_id_image_id', 'region');
	    $this->dropIndex('fk_region_flag_image_id_image_id', 'region');
	    $this->addForeignKey('fk_region_flag_image_id_image_id', 'region', 'flag_image_id', 'image', 'id', 'set null', 'set null');
	    $this->addForeignKey('fk_region_visit_image_id_image_id', 'region', 'visit_image_id', 'image', 'id', 'set null', 'set null');
	    $this->addForeignKey('fk_region_arms_image_id_image_id', 'region', 'arms_image_id', 'image', 'id', 'set null', 'set null');
    }

    public function down()
    {
	    return false;
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
