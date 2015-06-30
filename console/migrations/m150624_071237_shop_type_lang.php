<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_071237_shop_type_lang extends Migration
{
    use \modules\translations\components\LanguageTable;
    public $tableName = 'shop_type';
    public $additionalFields = [
        'description' => 'text default NULL',
    ];

    public function up()
    {
        return $this->createLang();
    }

    public function down()
    {
        return $this->deleteLang();
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
