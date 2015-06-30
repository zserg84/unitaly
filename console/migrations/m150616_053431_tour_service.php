<?php

use yii\db\Schema;
use yii\db\Migration;

class m150616_053431_tour_service extends Migration
{
    public function up()
    {
        $this->createTable('service_category', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL'
        ]);
        $this->createIndex('uidx_service_category_name', 'service_category', 'name', true);
        $this->execute('
            INSERT INTO service_category(name)
              SELECT NAME
                FROM service_type
        ');
        $this->delete('service_type');

        $this->addColumn('service_type', 'category_id', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addForeignKey('fk_service_type_category_id__service_category_id', 'service_type', 'category_id', 'service_category', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m150616_053431_tour_service cannot be reverted.\n";

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
