<?php

use yii\db\Schema;
use yii\db\Migration;

class m150629_111333_manufacture_type_lang extends Migration
{
    use \modules\translations\components\LanguageTable;
    public $tableName = 'manufacture_type';
    public $additionalFields = [
        'description' => 'TEXT default NULL',
    ];
    public $addFK = false;

    public function up()
    {
        $this->createLang();
        $this->addForeignKey('fk_' .$this->tableName . '_lang_type_id__' .$this->tableName . '_id', $this->tableName . '_lang', $this->tableName . '_id', $this->tableName, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_' .$this->tableName . '_lang_lang_id__lang_id', $this->tableName . '_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
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
