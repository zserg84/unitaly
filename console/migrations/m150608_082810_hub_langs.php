<?php

use yii\db\Schema;
use yii\db\Migration;
use modules\translations\components\LanguageTable;

class m150608_082810_hub_langs extends Migration
{
	use LanguageTable;
	public $tableName = 'hub';
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
