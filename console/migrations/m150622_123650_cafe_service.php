<?php

use yii\db\Schema;
use yii\db\Migration;

class m150622_123650_cafe_service extends Migration
{
    public function up()
    {
        $this->createTable('cafe_service', [
            'id' => 'pk',
            'cafe_id' => Schema::TYPE_INTEGER .' NOT NULL',
            'service_id' => Schema::TYPE_INTEGER .' NOT NULL',
            'active' => Schema::TYPE_BOOLEAN . ' COMMENT "Наличие типа кухни в кафе"',
            'price' => Schema::TYPE_DECIMAL . '(10,2) COMMENT "Средний чек"'
        ]);
        $this->addForeignKey('fk_cafe_service_cafe_id__cafe_id', 'cafe_service', 'cafe_id', 'cafe', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_cafe_service_service_id__additional_service_id', 'cafe_service', 'service_id', 'additional_service', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_cafe_service_cafe_service', 'cafe_service', 'cafe_id, service_id', true);

        $this->insert('service_category', [
            'id' => 4,
            'name' => 'Опции кафе',
        ]);

        $this->insert('service_type', [
            'category_id' => 4,
            'name' => 'Типы кухни',
        ]);
    }

    public function down()
    {
        $this->dropTable('cafe_service');
        $this->delete('service_category', [
            'id' => 4
        ]);
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
