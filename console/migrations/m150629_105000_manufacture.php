<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_105000_manufacture extends Migration
{
    public function up()
    {
        $this->createTable('manufacture_type', [
            'id' => 'pk',
        ]);
        $this->createTable('manufacture', [
            'id' => 'pk',
            'frontend' => Schema::TYPE_BOOLEAN . ' DEFAULT 0 COMMENT "Выводить на сайте"',
            'legal_entity' => Schema::TYPE_STRING .' COMMENT "Юр.лицо производства"',
            'network' => Schema::TYPE_STRING .' COMMENT "Принадлежность к сети"',
            'associations' => Schema::TYPE_STRING . ' COMMENT "Принадлежность к союзам и ассоциациям"',
            'manufacture_type_id' => Schema::TYPE_INTEGER. ' NOT NULL ',
            'image_id' => Schema::TYPE_INTEGER,
            'mediaface_image_id' => Schema::TYPE_INTEGER . ' COMMENT "Медиалицо производителя, изображение"',
            'mediaface_appeal' => Schema::TYPE_TEXT . ' COMMENT "Медиалицо производителя, обращение"',
            'city_id' => Schema::TYPE_INTEGER,
            'address' => Schema::TYPE_STRING . ' COMMENT " Адрес производства"',
            'latitude' => Schema::TYPE_STRING .'(50) COMMENT "Широта"',
            'longitude' => Schema::TYPE_STRING .'(50) COMMENT "Долгота"',
            'phone' => Schema::TYPE_STRING .'(50) COMMENT "Телефон"',
            'email' => Schema::TYPE_STRING .'(50) COMMENT "Email"',
            'site' => Schema::TYPE_STRING .'(50) COMMENT "Сайт"',
            'purchase_url' => Schema::TYPE_STRING .'(50) COMMENT "URL для покупок"',
            'facebook' => Schema::TYPE_STRING,
            'instagram' => Schema::TYPE_STRING,
        ]);
        $this->addForeignKey('manufacture_type_id__manufacture_type_id', 'manufacture', 'manufacture_type_id', 'manufacture_type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('manufacture_image_id__image_id', 'manufacture', 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('manufacture_mediaface_image_id__image_id', 'manufacture', 'mediaface_image_id', 'image', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('manufacture_city_id__city_id', 'manufacture', 'city_id', 'city', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('manufacture');
        $this->dropTable('manufacture_type');
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
