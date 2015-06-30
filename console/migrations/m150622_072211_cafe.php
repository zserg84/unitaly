<?php

use yii\db\Schema;
use yii\db\Migration;

class m150622_072211_cafe extends Migration
{
    public function up()
    {
        $this->createTable("cafe", [
            "id" => Schema::TYPE_PK,
            "frontend" => Schema::TYPE_BOOLEAN . " DEFAULT 0 comment 'Вывод кафе на фронтенд'",
            "rest_net" => Schema::TYPE_STRING . " comment 'Принадлежность к сети'",
            "city_id" => Schema::TYPE_INTEGER . " comment 'Принадлежность к городу'",
            "address" => Schema::TYPE_STRING . " comment 'Адрес кафе'",
            "placement_id" => Schema::TYPE_INTEGER . " comment 'Находится в одном здании с отелем'",
            "latitude" => Schema::TYPE_STRING . "(50) comment 'Широта'",
            "longitude" => Schema::TYPE_STRING . "(50) comment 'Долгота'",
            "logo_image_id" => Schema::TYPE_INTEGER . " comment 'Изображение - логотип кафе'",
            "site" => Schema::TYPE_STRING . " comment 'Официальный сайт'",
            "facebook" => Schema::TYPE_STRING . " comment 'Aкк Facebook'",
            "instagram" => Schema::TYPE_STRING . " comment 'Акк Instagram'"
        ]);
        $this->addForeignKey("fk_cafe_city_id__city_id", "cafe", "city_id", "city", "id", 'CASCADE', 'CASCADE');
        $this->addForeignKey("fk_cafe_placement_id__placement_id", "cafe", "placement_id", "placement", "id", 'SET NULL', 'CASCADE');
        $this->addForeignKey("fk_cafe_logo_image_id__image_id", "cafe", "logo_image_id", "image", "id", 'SET NULL', 'CASCADE');


    }

    public function down()
    {
        $this->dropTable('cafe');
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
