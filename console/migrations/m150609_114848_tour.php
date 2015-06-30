<?php

use yii\db\Schema;
use yii\db\Migration;

class m150609_114848_tour extends Migration
{
    public function up()
    {
        $this->createTable('tour_offer_type', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING .' NOT NULL',
        ], ' COMMENT "Признак спецпредложения"');
        $this->createIndex('uidx_tour_offer_type_name', 'tour_offer_type', 'name', true);

        $offers = [
            'Просто тур',
            'Last minute',
            'Hot',
            'Promo',
        ];
        foreach($offers as $offer){
            $this->insert('tour_offer_type', [
                'name' => $offer
            ]);
        }

        $this->createTable('service_type', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING .' NOT NULL',
        ], ' COMMENT "Типы дополнительных услуг"');
        $this->createIndex('uidx_service_type_name', 'service_type', 'name', true);

        $types = [
            'Опции туров',
            'Опции отелей',
            'Опции номеров',
        ];
        foreach($types as $k=> $type){
            $this->insert('service_type', [
                'id' => $k+1,
                'name' => $type
            ]);
        }

        $this->createTable('additional_service', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING .' NULL',
            'service_type_id' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], ' COMMENT "Дополнительные услуги"');
        $this->addForeignKey('fk_additional_service_service_type_id__service_type_id', 'additional_service', 'service_type_id', 'service_type', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_additional_service_name_service_type_id', 'additional_service', 'name, service_type_id', true);

        $this->createTable('additional_service_lang', [
            'id' => 'pk',
            'additional_service_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING .' NOT NULL',
        ], ' COMMENT "Дополнительные услуги (переводы)"');
        $this->addForeignKey('fk_additional_service_lang_service_id__additional_service_id', 'additional_service_lang', 'additional_service_id', 'additional_service', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_additional_service_lang_name_service_id', 'additional_service_lang', 'name, additional_service_id', true);

        $this->createTable('tour', [
            'id' => 'pk',
            'identifier' => Schema::TYPE_INTEGER . ' NOT NULL',
            'provider_id' => Schema::TYPE_INTEGER .' COMMENT "Поставщик тура"',
            'tour_type_id' => Schema::TYPE_INTEGER .' NOT NULL COMMENT "Тип тура"',
            'name' => Schema::TYPE_STRING . ' COMMENT "Наименование тура"',
            'days_cnt' => Schema::TYPE_INTEGER . ' COMMENT "Кол-во дней в туре"',
            'nights_cnt' => Schema::TYPE_INTEGER . ' COMMENT "Кол-во ночей в туре"',
            'city_id' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Город начала тура"',
            'date_start' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Дата начала тура"',
            'price' => Schema::TYPE_DECIMAL . '(10,2) COMMENT "Стоимость тура"',
            'food_type_id' => Schema::TYPE_INTEGER . ' COMMENT "Тип питания"',
            'short_description' => Schema::TYPE_STRING . ' COMMENT "Краткое описание тура"',
            'description' => Schema::TYPE_TEXT . ' COMMENT "Подробное описание тура"',
            'seller_name' => Schema::TYPE_STRING .' COMMENT "Имя представителя продавца тура"',
            'seller_phone' => Schema::TYPE_STRING .' COMMENT "телефон представителя продавца тура"',
            'seller_email' => Schema::TYPE_STRING .' COMMENT "email представителя продавца тура"',
            'image_id' => Schema::TYPE_INTEGER . ' COMMENT "Основное изображение тура"',
            'additional_image_id' => Schema::TYPE_INTEGER . ' COMMENT "Дополнительное изображение тура"',
            'tour_offer_type_id' => Schema::TYPE_INTEGER . ' COMMENT "Признак спецпредложения"',
        ]);
        $this->addForeignKey('fk_tour_provider_id__user_id', 'tour', 'provider_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_tour_tour_type_id__tour_type_id', 'tour', 'tour_type_id', 'tour_type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tour_city_id__city_id', 'tour', 'city_id', 'city', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tour_image_id__image_id', 'tour', 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_tour_additional_image_id__image_id', 'tour', 'additional_image_id', 'image', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk_tour_tour_offer_type_id__tour_offer_type_id', 'tour', 'tour_offer_type_id', 'tour_offer_type', 'id', 'SET NULL', 'CASCADE');

        $this->createTable('tour_service', [
            'id' => 'pk',
            'tour_id' => Schema::TYPE_INTEGER .' NOT NULL',
            'service_id' => Schema::TYPE_INTEGER .' NOT NULL',
            'active' => Schema::TYPE_BOOLEAN . ' COMMENT "Флаг включения услуги в стоимость тура"',
            'price' => Schema::TYPE_DECIMAL . '(10,2) COMMENT "Стоимость услуги"'
        ]);
        $this->addForeignKey('fk_tour_service_tour_id__tour_id', 'tour_service', 'tour_id', 'tour', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_tour_service_service_id__additional_service_id', 'tour_service', 'service_id', 'additional_service', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uidx_tour_service_tour_service', 'tour_service', 'tour_id, service_id', true);
    }

    public function down()
    {
        $this->dropTable('tour_service');
        $this->dropTable('tour');
        $this->dropTable('additional_service_lang');
        $this->dropTable('additional_service');
        $this->dropTable('service_type');
        $this->dropTable('tour_offer_type');
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
