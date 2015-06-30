<?php

use yii\db\Schema;
use yii\db\Migration;

class m150626_095522_room_type_lang extends Migration
{
	use \modules\translations\components\LanguageTable;
	public $tableName = 'room_type';
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
