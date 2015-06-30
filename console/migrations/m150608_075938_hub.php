<?php

use yii\db\Schema;
use yii\db\Migration;

class m150608_075938_hub extends Migration
{
    public function up()
    {
	    $this->addColumn('hub', 'identifier', 'varchar(20) not null comment "идентификатор"');
	    $this->addColumn('hub', 'image_id', 'int default null comment "изображение хаба"');
	    $this->addColumn('hub', 'description', 'text default null comment "описание хаба"');
	    $this->addColumn('hub', 'city_id', 'int not null comment "центральный город хаба"');
	    $this->addColumn('hub', 'airport', 'varchar(255) default null comment "аэропорт прибытия хаба"');
	    $this->addColumn('hub', 'port', 'varchar(255) default null comment "порт прибытия хаба"');
	    $this->addColumn('hub', 'code_iata', 'varchar(255) default null comment "код узла, авиа, IATA"');
	    $this->addColumn('hub', 'code_icao', 'varchar(255) default null comment "код узла, авиа, ICAO"');
	    $this->addColumn('hub', 'arrival_table', 'varchar(255) default null comment "ссылка на онлайн-табло, прилет"');
	    $this->addColumn('hub', 'departure_table', 'varchar(255) default null comment "ссылка на онлайн-табло, вылет"');
	    $this->addForeignKey('fk_hub_city_id_city_id', 'hub', 'city_id', 'city', 'id', 'no action', 'no action');
	    $this->addForeignKey('fk_hub_image_id_image_id', 'hub', 'image_id', 'image', 'id', 'set null', 'set null');

	    $this->createIndex('uidx_hub_identifier', 'hub', 'identifier', true);
	    $this->createIndex('uidx_city_identifier', 'city', 'identifier', true);
	    $this->createIndex('uidx_region_identifier', 'region', 'identifier', true);

    }

    public function down()
    {
	    $this->dropIndex('uidx_city_identifier', 'city');
	    $this->dropIndex('uidx_region_identifier', 'region');
	    $this->dropIndex('uidx_hub_identifier', 'hub');
	    $this->dropForeignKey('fk_hub_city_id_city_id', 'hub');
	    $this->dropForeignKey('fk_hub_image_id_image_id', 'hub');
	    $this->dropColumn('hub', 'image_id');
	    $this->dropColumn('hub', 'city_id');
	    $this->dropColumn('hub', 'airport');
	    $this->dropColumn('hub', 'port');
	    $this->dropColumn('hub', 'code_iata');
	    $this->dropColumn('hub', 'code_icao');
	    $this->dropColumn('hub', 'arrival_table');
	    $this->dropColumn('hub', 'departure_table');
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
