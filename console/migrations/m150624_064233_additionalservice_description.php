<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_064233_additionalservice_description extends Migration
{
    public function up()
    {
	    $this->addColumn('additional_service', 'description', 'text default null comment "описание"');
	    $this->dropIndex('uidx_additional_service_name_service_type_id', 'additional_service');
    }

    public function down()
    {
	    $this->dropColumn('additional_service', 'description');
	    $this->createIndex('uidx_additional_service_name_service_type_id', 'additional_service',  ['name', 'service_type_id'], true);
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
