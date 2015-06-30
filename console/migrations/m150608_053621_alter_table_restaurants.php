<?php

use yii\db\Schema;
use yii\db\Migration;

class m150608_053621_alter_table_restaurants extends Migration
{
    public function safeUp()
    {
        if ($this->db->schema->getTableSchema('restaurant_lang', true) !== null) {
            $this->dropTable('restaurant_lang');
        }

        if ($this->db->schema->getTableSchema('restaurant', true) !== null) {
            $this->dropForeignKey("fk_restaurant_city", "restaurant");
            $this->dropForeignKey("fk_restaurant_hotel", "restaurant");
            $this->dropForeignKey("fk_restaurant_region", "restaurant");
            $this->dropTable('restaurant');
        }

        $this->createTable("restaurant", [
            "id" => Schema::TYPE_PK . " comment 'ID Ресторана'",
            "frontend" => Schema::TYPE_SMALLINT . " comment 'Вывод ресторана на фронт-енд'",
            "name" => Schema::TYPE_STRING . " comment 'Название ресторана'",
            "spellings" => Schema::TYPE_STRING . " comment 'Дополнительные варианты написания'",
            "rest_net" => Schema::TYPE_STRING . " comment 'Принадлежность к сети ресторанов'",
            "stars" => Schema::TYPE_INTEGER . " comment 'Звездность'",
            "region_id" => Schema::TYPE_INTEGER . " comment 'Региональная принадлежность'",
            "city_id" => Schema::TYPE_INTEGER . " comment 'Принадлежность к городу'",
            "latitude" => Schema::TYPE_DECIMAL . " comment 'Широта'",
            "longitude" => Schema::TYPE_DECIMAL . " comment 'Долгота'",
            "logo_image_id" => Schema::TYPE_INTEGER . " comment 'Изображение - логотип ресторана'",
            "menu_image_id" => Schema::TYPE_INTEGER . " comment 'Загрузить меню'",
            "address" => Schema::TYPE_STRING . " comment 'Адрес ресторана'",
            "hotel_id" => Schema::TYPE_INTEGER . " comment 'Находится в одном здании с отелем'",
            "worktime" => Schema::TYPE_STRING . " comment 'Время работы на русском'",
            "main_phone" => Schema::TYPE_STRING . " comment 'Основной телефон ресторана'",
            "add_phone" => Schema::TYPE_STRING . " comment 'Дополнительные телефоны'",
            "site" => Schema::TYPE_STRING . " comment 'Официальный сайт'",
            "facebook" => Schema::TYPE_STRING . " comment 'Aкк Facebook'",
            "instagram" => Schema::TYPE_STRING . " comment 'Акк Instagram'",
            "identifier" => Schema::TYPE_INTEGER
        ]);
        
        $this->addForeignKey("fk_restaurant_city", "restaurant", "city_id", "city", "id", 'CASCADE', 'CASCADE');
        $this->addForeignKey("fk_restaurant_hotel", "restaurant", "hotel_id", "hotel", "id", 'CASCADE', 'CASCADE');
        $this->addForeignKey("fk_restaurant_region", "restaurant", "region_id", "region", "id", 'CASCADE', 'CASCADE');

        $this->createTable('restaurant_lang', [
            'id' => 'pk',
            'restaurant_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING,
            'worktime' => Schema::TYPE_STRING,
        ]);

        $this->addForeignKey('fk_restaurant_lang___restaurant', 'restaurant_lang', 'restaurant_id', 'restaurant', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_restaurant___lang', 'restaurant_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey("fk_restaurant_lang___restaurant", "restaurant_lang");
        $this->dropForeignKey("fk_restaurant___lang", "restaurant_lang");
        $this->dropTable("restaurant_lang");
    }
}
