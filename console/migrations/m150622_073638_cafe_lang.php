<?php

use yii\db\Schema;
use yii\db\Migration;

class m150622_073638_cafe_lang extends Migration
{
    use \modules\translations\components\LanguageTable;
    public $tableName = 'cafe';
    public $additionalFields = [
        'spellings' => 'text default NULL',
        'address' => 'text default NULL COMMENT "Адрес"',
        'worktime' => 'text default NULL COMMENT "Время работы"',
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
