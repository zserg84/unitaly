<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_071413_province extends Migration
{
    public function up()
    {
        $this->createTable('province', [
            'id' => 'pk',
        ]);
        $this->addColumn('province', 'region_id', 'int not null comment "Регион"');
        $this->addColumn('province', 'visit_image_id', 'int default null comment "Визитка провинции"');
        $this->addColumn('province', 'arms_image_id', 'int default null comment "Герб провинции"');
        $this->addColumn('province', 'flag_image_id', 'int default null comment "Флаг провинции"');
        $this->addColumn('province', 'city_id', 'int default null comment "административный центр провинции"');

        $this->addForeignKey('fk_province_region_id_region_id', 'province', 'region_id', 'region', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_province_city_id_city_id', 'province', 'city_id', 'city', 'id', 'set null', 'set null');
        $this->addForeignKey('fk_province_visit_image_id_image_id', 'province', 'visit_image_id', 'image', 'id', 'set null', 'set null');
        $this->addForeignKey('fk_province_arms_image_id_image_id', 'province', 'arms_image_id', 'image', 'id', 'set null', 'set null');
        $this->addForeignKey('fk_province_flag_image_id_image_id', 'province', 'flag_image_id', 'image', 'id', 'set null', 'set null');
    }

    public function down()
    {
        $this->dropTable('province');
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
