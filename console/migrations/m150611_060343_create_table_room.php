<?php

use yii\db\Schema;
use yii\db\Migration;

class m150611_060343_create_table_room extends Migration
{
    public function safeUp()
    {
        if ($this->db->schema->getTableSchema('room_lang', true) !== null) {
            $this->dropTable('room_lang');
        }

        if ($this->db->schema->getTableSchema('room', true) !== null) {
            $this->dropTable('room');
        }

        $this->createTable("room", [
            "id" => Schema::TYPE_PK . " comment 'ID Номера'",
            "active" => Schema::TYPE_SMALLINT . " comment 'Номер активен'",
            "placement_id" => Schema::TYPE_INTEGER . " comment 'Принадлежность к отелю'",
            "building" => Schema::TYPE_STRING . " comment 'Принадлежность к строению'",
            "room_type_id" => Schema::TYPE_INTEGER . " comment 'Тип номера'",
            "area" => Schema::TYPE_STRING . " comment 'Площадь номера, кв.м.'",
            "bed" => Schema::TYPE_STRING . " comment 'Число кроватей, взрослых'",
            "capacity" => Schema::TYPE_STRING . " comment 'Вместимость, максимальная'",
            "price" => Schema::TYPE_STRING . " comment 'Цена за сутки'",
            "time" => Schema::TYPE_STRING . " comment 'Время заселения/выселения'",
            "main_image_id" => Schema::TYPE_INTEGER . " comment 'Основное изображение места размещения'",
            "add_image_id" => Schema::TYPE_INTEGER . " comment 'Дополнительное изображение места размещения'",
            "desc_short" => Schema::TYPE_STRING . " comment 'Краткое описание номера'",
            "desc_full" => Schema::TYPE_STRING . " comment 'Подробное описание номера'",
            "identifier" => Schema::TYPE_INTEGER
        ]);

        $this->createTable('room_lang', [
            'id' => 'pk',
            'room_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'desc_short' => Schema::TYPE_STRING,
            'desc_full' => Schema::TYPE_STRING,
        ]);

        $this->addForeignKey('fk_room___placement', 'room', 'placement_id', 'placement', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_room_lang___room', 'room_lang', 'room_id', 'room', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_room___lang', 'room_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey("fk_room_lang___room", "room_lang");
        $this->dropForeignKey("fk_room___lang", "room_lang");
        $this->dropForeignKey("fk_room___placement", "room");
        $this->dropTable("room_lang");
        $this->dropTable("room");
    }
}
