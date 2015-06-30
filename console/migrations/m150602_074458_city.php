<?php

use yii\db\Schema;
use yii\db\Migration;

class m150602_074458_city extends Migration
{
    public function up()
    {
	    $this->createTable('hub', [
		    'id' => Schema::TYPE_PK,
		    'name' => 'varchar(255) not null comment "наименование"',
	    ]);

	    $this->addColumn('city', 'identifier', 'varchar(20) not null comment "идентификатор"');
	    $this->addColumn('city', 'name', 'varchar(50) not null comment "наименование города"');
	    $this->addColumn('city', 'spellings', 'text not null comment "дополнительные варианты написания"');
	    $this->addColumn('city', 'region_id', 'int not null comment "региональная принадлежность"');
	    $this->addColumn('city', 'visit_image_id', 'int default null comment "визитка города"');
	    $this->addColumn('city', 'arms_image_id', 'int default null comment "герб города"');
	    $this->addColumn('city', 'description', 'text not null comment "описание"');
	    $this->addColumn('city', 'latitude', 'varchar(255) default null comment "широта"');
	    $this->addColumn('city', 'longitude', 'varchar(255) default null comment "долгота"');
	    $this->addColumn('city', 'hub_id', 'int default null comment "идентификатор"');
	    $this->addColumn('city', 'history', 'text default null comment "краткая история города"');

	    $this->addForeignKey('fk_city_region_id_region_id', 'city', 'region_id', 'region', 'id', 'cascade', 'cascade');
	    $this->addForeignKey('fk_city_visit_image_id_image_id', 'city', 'visit_image_id', 'image', 'id', 'set null', 'set null');
	    $this->addForeignKey('fk_city_arms_image_id_image_id', 'city', 'arms_image_id', 'image', 'id', 'set null', 'set null');
	    $this->addForeignKey('fk_city_hub_id_hub_id', 'city', 'hub_id', 'hub', 'id', 'set null', 'set null');
    }

    public function down()
    {
	    $this->dropForeignKey('fk_city_region_id_region_id', 'city');
	    $this->dropForeignKey('fk_city_visit_image_id_image_id', 'city');
	    $this->dropForeignKey('fk_city_arms_image_id_image_id', 'city');
	    $this->dropForeignKey('fk_city_hub_id_hub_id', 'city');

	    $this->dropColumn('city', 'identifier');
	    $this->dropColumn('city', 'name');
	    $this->dropColumn('city', 'spellings');
	    $this->dropColumn('city', 'region_id');
	    $this->dropColumn('city', 'visit_image_id');
	    $this->dropColumn('city', 'arms_image_id');
	    $this->dropColumn('city', 'description');
	    $this->dropColumn('city', 'latitude');
	    $this->dropColumn('city', 'longitude');
	    $this->dropColumn('city', 'hub_id');
	    $this->dropColumn('city', 'history');

	    $this->dropTable('hub');
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
