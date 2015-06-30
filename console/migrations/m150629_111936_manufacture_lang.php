<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_111936_manufacture_lang extends Migration
{
    use \modules\translations\components\LanguageTable;
    public $tableName = 'manufacture';
    public $additionalFields = [
        'spellings' => 'TEXT default NULL',
        'mediaface_name' => 'VARCHAR(255)',
        'worktime' => 'VARCHAR(50)',
    ];

    public function up()
    {
        $this->createLang();
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
