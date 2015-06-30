<?php

use yii\db\Schema;
use yii\db\Migration;

class m150602_055233_showplace extends Migration
{
    public function up()
    {

        $this->createTable('image', [
            'id' => 'pk',
            'ext' => Schema::TYPE_STRING.'(4)',
            'comment' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'sort' => Schema::TYPE_INTEGER,
        ]);

        $this->createTable('region', [
            'id' => 'pk',
        ]);

        $this->createTable('city', [
            'id' => 'pk',
        ]);

        $this->createTable('showplace_type', [
            'id' => 'pk',
            'identifier' => Schema::TYPE_INTEGER .' NOT NULL COMMENT "Идентификатор типа достопримечательности"',
            'name' => Schema::TYPE_STRING .' NOT NULL COMMENT "Название"',
            'description' => Schema::TYPE_TEXT,
        ]);
        $this->createIndex('uidx_showplace_type_identifier', 'showplace_type', 'identifier', true);

        $this->createTable('showplace', [
            'id' => 'pk',
            'identifier' => Schema::TYPE_INTEGER .' NOT NULL COMMENT "Идентификатор достопримечательности"',
            'name' => Schema::TYPE_STRING .' NOT NULL COMMENT "Название"',
            'org_service_provider' => Schema::TYPE_TEXT,
            'showplace_type_id' => Schema::TYPE_INTEGER .' NOT NULL COMMENT "Тип достопримечательности"',
            'region_id' => Schema::TYPE_INTEGER .' NOT NULL COMMENT "Регион"',
            'city_id' => Schema::TYPE_INTEGER .' NOT NULL COMMENT "Город/место"',
            'address' => Schema::TYPE_STRING .' NOT NULL COMMENT "Адрес"',
            'image_id' => Schema::TYPE_INTEGER . ' COMMENT "Основное изображение"',
            'additional_image_id' => Schema::TYPE_INTEGER . ' COMMENT "Доп.изображение"',
            'latitude' => Schema::TYPE_STRING . ' COMMENT "Широта"',
            'longitude' => Schema::TYPE_STRING .' COMMENT "Долгота"',
            'short_description' => Schema::TYPE_STRING . ' NOT NULL COMMENT "Краткое описание"',
            'description' => Schema::TYPE_TEXT . ' NOT NULL COMMENT "Подробное описание"',
            'representative_name' => Schema::TYPE_STRING . ' COMMENT "Имя представителя"',
            'representative_phone' => Schema::TYPE_STRING . ' COMMENT "Телефон представителя"',
            'representative_email' => Schema::TYPE_STRING . '(50) COMMENT "Email представителя"',
            'site' => Schema::TYPE_STRING . ' COMMENT "Сайт"',
            'facebook' => Schema::TYPE_STRING . ' COMMENT "Ссылка на facebook"',
            'instagram' => Schema::TYPE_STRING . ' COMMENT "Ссылка на инстаграм"',
            'price_adult' => Schema::TYPE_DOUBLE . ' (10, 2) COMMENT "Цена посещения для взрослого"',
            'price_child' => Schema::TYPE_DOUBLE . ' (10,2) COMMENT "Цена посещения для ребенка"',
            'schedule' => Schema::TYPE_STRING . ' COMMENT "Расписание работы"',
            'has_excursion' => Schema::TYPE_BOOLEAN . ' COMMENT "Наличие экскурсии"',
            'price_excursion_guide_group' => Schema::TYPE_DOUBLE . '(10,2) COMMENT "Стоимость экскурсии в группе с гидом"',
            'price_excursion_guide_individual' => Schema::TYPE_DOUBLE . '(10,2) COMMENT "Стоимость индивидуальной экскурсии с гидом"',
            'price_excursion_guide_audio' => Schema::TYPE_DOUBLE . '(10,2) COMMENT "Стоимость экскурсии аудио-гид"',
            'additional' => Schema::TYPE_TEXT .' COMMENT "Дополнительные товары и услуги"',
        ]);

        $this->createIndex('uidx_showplace_identifier', 'showplace', 'identifier', true);
        $this->addForeignKey('fk_showplace_showplace_type_id__showplace_type_id', 'showplace', 'showplace_type_id', 'showplace_type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_showplace_image_id__image_id', 'showplace', 'image_id', 'image', 'id', 'SET NULL', 'SET NULL');
        $this->addForeignKey('fk_showplace_additional_image_id__image_id', 'showplace', 'additional_image_id', 'image', 'id', 'SET NULL', 'SET NULL');
    }

    public function down()
    {
        $this->dropTable('showplace');
        $this->dropTable('showplace_type');
        $this->dropTable('city');
        $this->dropTable('region');
        $this->dropTable('image');
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
