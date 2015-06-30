<?php

use yii\db\Schema;
use yii\db\Migration;

class m150602_113145_regions extends Migration
{
    public function up()
    {
	    $this->addColumn('region', 'identifier', 'varchar(20) not null comment "идентификатор"');
	    $this->addColumn('region', 'name', 'varchar(50) not null comment "наименование города"');
	    $this->addColumn('region', 'spellings', 'text not null comment "дополнительные варианты написания"');
	    $this->addColumn('region', 'visit_image_id', 'int default null comment "визитка региона"');
	    $this->addColumn('region', 'arms_image_id', 'int default null comment "герб региона"');
	    $this->addColumn('region', 'city_id', 'int default null comment "административный центр региона"');
	    $this->addColumn('region', 'description', 'text not null comment "описание"');
	    $this->addForeignKey('fk_region_city_id_city_id', 'region', 'city_id', 'city', 'id', 'set null', 'set null');
	    $this->addForeignKey('fk_region_visit_image_id_image_id', 'region', 'visit_image_id', 'image', 'id', 'set null', 'set null');
	    $this->addForeignKey('fk_region_arms_image_id_image_id', 'region', 'arms_image_id', 'image', 'id', 'set null', 'set null');

    }

    public function down()
    {
	    $this->dropForeignKey('fk_region_city_id_city_id', 'region');
	    $this->dropForeignKey('fk_region_visit_image_id_image_id', 'region');
	    $this->dropForeignKey('fk_region_arms_image_id_image_id', 'region');
	    $this->dropColumn('region', 'identifier');
	    $this->dropColumn('region', 'name');
	    $this->dropColumn('region', 'spellings');
	    $this->dropColumn('region', 'visit_image_id');
	    $this->dropColumn('region', 'arms_image_id');
	    $this->dropColumn('region', 'city_id');
	    $this->dropColumn('region', 'description');
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
