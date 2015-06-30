<?php

use yii\db\Schema;
use yii\db\Migration;

class m150602_080320_create_restaurants_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('hotel', [
            'id' => Schema::TYPE_PK,
            'name' => 'varchar(255) not null comment "наименование"',
        ]);

        $this->createTable("restaurant", [
            "id" => Schema::TYPE_BIGPK . " comment 'ID Ресторана'",
            "frontend" => Schema::TYPE_SMALLINT . " comment 'Вывод ресторана на фронт-енд'",
            "name_rus" => Schema::TYPE_STRING . " comment 'Название ресторана, русский'",
            "name_ita" => Schema::TYPE_STRING . " comment 'Название hub, итальянский'",
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
            "worktime_rus" => Schema::TYPE_STRING . " comment 'Время работы на русском'",
            "worktime_ita" => Schema::TYPE_STRING . " comment 'Время работы на итальянском'",
            "main_phone" => Schema::TYPE_STRING . " comment 'Основной телефон ресторана'",
            "add_phone" => Schema::TYPE_STRING . " comment 'Дополнительные телефоны'",
            "site" => Schema::TYPE_STRING . " comment 'Официальный сайт'",
            "facebook" => Schema::TYPE_STRING . " comment 'Aкк Facebook'",
            "instagram" => Schema::TYPE_STRING . " comment 'Акк Instagram'",
            "identifier" => Schema::TYPE_INTEGER
        ]);

        $this->addForeignKey("fk_restaurant_city", "restaurant", "city_id", "city", "id");
        $this->addForeignKey("fk_restaurant_hotel", "restaurant", "hotel_id", "hotel", "id");
        $this->addForeignKey("fk_restaurant_region", "restaurant", "region_id", "region", "id");
    }

    public function safeDown()
    {
        $this->dropForeignKey("fk_restaurant_city", "restaurant");
        $this->dropForeignKey("fk_restaurant_hotel", "restaurant");
        $this->dropForeignKey("fk_restaurant_region", "restaurant");
        $this->dropTable("restaurant");
        $this->dropTable("hotel");
    }
}
