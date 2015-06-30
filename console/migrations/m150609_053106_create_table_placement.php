<?php

use yii\db\Schema;
use yii\db\Migration;

class m150609_053106_create_table_placement extends Migration
{
    public function safeUp()
    {
        if ($this->db->schema->getTableSchema('placement_lang', true) !== null) {
            $this->dropTable('placement_lang');
        }

        if ($this->db->schema->getTableSchema('placement', true) !== null) {
            $this->dropTable('placement');
        }

        $this->createTable("placement", [
            "id" => Schema::TYPE_PK . " comment 'ID места размещения'",
            "frontend" => Schema::TYPE_SMALLINT . " comment 'Вывод на фронт-енд'",
            "name" => Schema::TYPE_STRING . " comment 'Название места размещения'",
            "spellings" => Schema::TYPE_STRING . " comment 'Дополнительные варианты написания'",
            "placement_type_id" => Schema::TYPE_INTEGER . " comment 'Тип места размещения'",
            "placement_sub_type_id" => Schema::TYPE_INTEGER . " comment 'Подтип места размещения'",
            "placement_net" => Schema::TYPE_STRING . " comment 'Принадлежность к сети'",
            "rooms" => Schema::TYPE_INTEGER . " comment 'Количество номеров'",
            "cheap" => Schema::TYPE_STRING . " comment 'Цена самого дешёвого номера (за сутки)'",
            "expensive" => Schema::TYPE_STRING . " comment 'Цена самого дорогого номера (за сутки)'",
            "city_id" => Schema::TYPE_INTEGER . " comment 'Принадлежность к городу'",
            "logo_image_id" => Schema::TYPE_INTEGER . " comment 'Логотип места размещения'",
            "add_image_id" => Schema::TYPE_INTEGER . " comment 'Дополнительное изображение места размещения'",
            "address" => Schema::TYPE_STRING . " comment 'Адрес места размещения'",
            "main_phone" => Schema::TYPE_STRING . " comment 'Основной телефон отеля'",
            "add_phone" => Schema::TYPE_STRING . " comment 'Дополнительные телефоны'",
            "fax" => Schema::TYPE_STRING . " comment 'Факс'",
            "email" => Schema::TYPE_STRING . " comment 'Контактный e-mail'",
            "site" => Schema::TYPE_STRING . " comment 'Официальный сайт'",
            "facebook" => Schema::TYPE_STRING . " comment 'Aкк Facebook'",
            "instagram" => Schema::TYPE_STRING . " comment 'Акк Instagram'",
            "desc_short" => Schema::TYPE_STRING . " comment 'Краткое описание места размещения'",
            "desc_full" => Schema::TYPE_STRING . " comment 'Подробное описание места размещения'",
            "latitude" => Schema::TYPE_DECIMAL . " comment 'Широта'",
            "longitude" => Schema::TYPE_DECIMAL . " comment 'Долгота'",
            "hub_id" => Schema::TYPE_INTEGER . " comment 'Принадлежность к Хаб'",
            "services" => Schema::TYPE_STRING . " comment 'Дополнительные услуги'",
            "identifier" => Schema::TYPE_INTEGER
        ]);

        $this->createTable('placement_lang', [
            'id' => 'pk',
            'placement_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING,
        ]);

        $this->addForeignKey('fk_placement_lang___placement', 'placement_lang', 'placement_id', 'placement', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_placement___lang', 'placement_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey("fk_placement_city", "placement", "city_id", "city", "id", 'CASCADE', 'CASCADE');
        $this->addForeignKey("fk_placement_hub", "placement", "hub_id", "hub", "id", 'CASCADE', 'CASCADE');
        $this->addForeignKey("fk_placement___placement_type", "placement", "placement_type_id", "placement_type", "id", 'CASCADE', 'CASCADE');
        $this->addForeignKey("fk_placement___placement_sub_type", "placement", "placement_sub_type_id", "placement_sub_type", "id", 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey("fk_placement___placement_sub_type", "placement");
        $this->dropForeignKey("fk_placement___placement_type", "placement");
        $this->dropForeignKey("fk_placement_hub", "placement");
        $this->dropForeignKey("fk_placement_city", "placement");
        $this->dropForeignKey("fk_placement___lang", "placement_lang");
        $this->dropForeignKey("fk_placement_lang___placement", "placement_lang");

        $this->dropTable('placement_lang');
        $this->dropTable('placement');
    }
}
