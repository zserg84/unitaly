<?php

use yii\db\Schema;
use yii\db\Migration;

class m150622_095932_sevice_langs_desc extends Migration
{
    public function up()
    {
	    $this->addColumn('additional_service_lang', 'description', Schema::TYPE_TEXT . ' DEFAULT NULL comment "описание"');
	    $this->dropIndex('uidx_additional_service_lang_name_service_id', 'additional_service_lang');
	    $this->createIndex('uidx_additional_service_lang_name_service_id', 'additional_service_lang', 'name, additional_service_id, lang_id', true);
	    $this->addColumn('additional_service', 'image_id', Schema::TYPE_INTEGER . ' COMMENT "Пинтограмма-изображение для опции"');
	    $this->addForeignKey('fk_additional_service_image_id__image_id', 'additional_service', 'image_id', 'image', 'id', 'SET NULL', 'SET NULL');
    }

    public function down()
    {
	    $this->dropForeignKey('fk_additional_service_image_id__image_id', 'additional_service');
	    $this->dropColumn('additional_service', 'image_id');
	    $this->dropColumn('additional_service_lang', 'description');
	    $this->dropIndex('uidx_additional_service_lang_name_service_id', 'additional_service_lang');
	    $this->createIndex('uidx_additional_service_lang_name_service_id', 'additional_service_lang', 'name, additional_service_id', true);
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
