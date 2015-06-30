<?php

use yii\db\Schema;
use yii\db\Migration;

class m150603_074300_create_table_occupancy_type extends Migration
{
    public function safeUp()
    {
        $this->createTable('occupancy_sub_type', [
            'id' => Schema::TYPE_PK,
            'name' => 'varchar(255) not null comment "наименование"',
        ]);

        $this->createTable("occupancy_type", [
            "id" => Schema::TYPE_BIGPK . " comment 'ID Типа размещения'",
            "name_rus" => Schema::TYPE_STRING . " comment 'Название типа проживания, русский'",
            "name_ita" => Schema::TYPE_STRING . " comment 'Название типа проживания, итальянский'",
            "subtype_id" => Schema::TYPE_INTEGER . " comment 'Подтип места размещения'",
            "image_id" => Schema::TYPE_INTEGER . " comment 'Изображение типа размещения'",
            "identifier" => Schema::TYPE_INTEGER . " comment 'идентификатор'"
        ]);

        $this->addForeignKey("fk_occupancy_type_occupancy_sub_type", "occupancy_type", "subtype_id", "occupancy_sub_type", "id");
    }

    public function safeDown()
    {
        $this->dropForeignKey("fk_occupancy_type_occupancy_sub_type", "occupancy_type");
        $this->dropTable("occupancy_type");
        $this->dropTable("occupancy_sub_type");
    }
}
