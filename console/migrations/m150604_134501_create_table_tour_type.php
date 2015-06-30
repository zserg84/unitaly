<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_134501_create_table_tour_type extends Migration
{
    public function safeUp()
    {
        $this->createTable("tour_type", [
            "id" => Schema::TYPE_BIGPK . " comment 'ID Типа тура'",
            "name_rus" => Schema::TYPE_STRING . " comment 'Название типа тура, русский'",
            "name_ita" => Schema::TYPE_STRING . " comment 'Название типа тура, итальянский'",
            "desc_rus" => Schema::TYPE_STRING . " comment 'Описание типа тура, русский'",
            "desc_ita" => Schema::TYPE_STRING . " comment 'Описание типа тура, итальянский'",
            "image_id" => Schema::TYPE_INTEGER . " comment 'Изображение типа тура'",
            "identifier" => Schema::TYPE_INTEGER
        ]);
    }

    public function safeDown()
    {
        $this->dropTable("tour_type");
    }
}
