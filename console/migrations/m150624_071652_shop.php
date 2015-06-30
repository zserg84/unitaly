<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_071652_shop extends Migration
{
    public function up()
    {
        $this->createTable('good_category', [
            'id' => 'pk',
            'image_id' => Schema::TYPE_INTEGER,
        ]);
        $this->addForeignKey('good_category_image_id__image_id', 'good_category', 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');

        $this->createTable('good_category_lang', [
            'id' => 'pk',
            'good_category_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'name' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
        ]);
        $this->addForeignKey('good_category_lang_category_id__good_category_id', 'good_category_lang', 'good_category_id', 'good_category', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_good_category_lang_category_name', 'good_category_lang', 'good_category_id, name', true);

        $this->createTable('shop', [
            'id' => 'pk',
            'frontend' => Schema::TYPE_BOOLEAN .' COMMENT "Выводить на сайте"',
            'city_id' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Город"',
            'latitude' => Schema::TYPE_STRING.'(50) COMMENT "Широта"',
            'longitude' => Schema::TYPE_STRING.'(50) COMMENT "Долгота"',
            'phone' => Schema::TYPE_STRING.'(50) COMMENT "Основной телефон"',
            'phone_additional' => Schema::TYPE_STRING.'(255) COMMENT "Дополнительные телефоны"',
            'phone_additional_comment' => Schema::TYPE_STRING.'(255) COMMENT "Комментарий к доп.телефонам"',
            'fax' => Schema::TYPE_STRING.'(255) COMMENT "Факс"',
            'email' => Schema::TYPE_STRING.'(255) COMMENT "Контактный Email"',
            'network' => Schema::TYPE_STRING . "(255) comment 'Принадлежность к сети'",
            'site' => Schema::TYPE_STRING . ' comment "Сайт"',
            'facebook' => Schema::TYPE_STRING . ' comment "Фейсбук"',
            'instagram' => Schema::TYPE_STRING . ' comment "Инстаграм"',
            'short_description' => Schema::TYPE_TEXT . ' comment "Краткое описание"',
            'description' => Schema::TYPE_TEXT . ' comment "Подробное описание"',
            'logo_image_id' => Schema::TYPE_INTEGER .' comment "Логотип"',
            'main_image_id' => Schema::TYPE_INTEGER .' comment "Основное изображение"',
            'additional_image_id' => Schema::TYPE_INTEGER .' comment "Дополнительное изображение"',
        ]);
        $this->addForeignKey('shop_city_id__city_id', 'shop', 'city_id', 'city', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('shop_logo_image_id__image_id', 'shop', 'logo_image_id', 'image', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('shop_main_image_id__image_id', 'shop', 'main_image_id', 'image', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('shop_additional_image_id__image_id', 'shop', 'additional_image_id', 'image', 'id', 'SET NULL', 'CASCADE');

        $this->createTable('shop_good_category', [
            'id' => 'pk',
            'shop_id' => Schema::TYPE_INTEGER .' NOT NULL',
            'good_category_id' => Schema::TYPE_INTEGER .' NOT NULL',
        ]);
        $this->addForeignKey('shop_good_category_shop_id__shop_id', 'shop_good_category', 'shop_id', 'shop', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('shop_good_category_category_id__good_category_id', 'shop_good_category', 'good_category_id', 'good_category', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_shop_good_category_shop_category', 'shop_good_category', 'good_category_id, shop_id', true);
    }

    public function down()
    {
        $this->dropTable('shop_good_category');
        $this->dropTable('shop');
        $this->dropTable('good_category_lang');
        $this->dropTable('good_category');
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
