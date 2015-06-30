<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_074447_shop_lang extends Migration
{
    use \modules\translations\components\LanguageTable;
    public $tableName = 'shop';
    public $additionalFields = [
        'spellings' => 'VARCHAR(255) default NULL',
        'address' => 'VARCHAR(255) default NULL',
        'worktime' => 'VARCHAR(50) default NULL',
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
