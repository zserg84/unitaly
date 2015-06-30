<?php

use yii\db\Schema;
use yii\db\Migration;

class m150608_082203_create_placement extends Migration
{
    public function safeUp()
    {
        $this->createTable('placement_sub_type', [
            'id' => Schema::TYPE_PK,
            'name' => 'varchar(255) not null comment "наименование"',
        ]);

        $this->createTable("placement_type", [
            "id" => Schema::TYPE_PK . " comment 'ID Типа размещения'",
            "name" => Schema::TYPE_STRING . " comment 'Название типа проживания'",
            "subtype_id" => Schema::TYPE_INTEGER . " comment 'Подтип места размещения'",
            "image_id" => Schema::TYPE_INTEGER . " comment 'Изображение типа размещения'",
            "identifier" => Schema::TYPE_INTEGER . " comment 'идентификатор'"
        ]);

        $this->createTable('placement_type_lang', [
            'id' => 'pk',
            'placement_type_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING
        ]);

        $this->addForeignKey('fk_placement_type_lang___placement_type', 'placement_type_lang', 'placement_type_id', 'placement_type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_placement_type_lang___lang', 'placement_type_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey("fk_placement_type___placement_sub_type", "placement_type", "subtype_id", "placement_sub_type", "id", 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey("fk_placement_type_lang___placement_type", "placement_type_lang");
        $this->dropForeignKey("fk_placement_type_lang___lang", "placement_type_lang");
        $this->dropForeignKey("fk_placement_type___placement_sub_type", "placement_type");
        $this->dropTable("placement_type");
        $this->dropTable("placement_sub_type");
        $this->dropTable("placement_type_lang");
    }
}
