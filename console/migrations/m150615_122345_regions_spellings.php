<?php

use yii\db\Schema;
use yii\db\Migration;

class m150615_122345_regions_spellings extends Migration
{
	public function up()
	{
		$this->addColumn('city_lang', 'spellings', 'text default NULL comment "дополнительные варианты написания"');
		$this->addColumn('region_lang', 'spellings', 'text default NULL comment "дополнительные варианты написания"');
		$this->alterColumn('city', 'spellings', 'text default null comment "дополнительные варианты написания"');
		$this->alterColumn('region', 'spellings', 'text default null comment "дополнительные варианты написания"');
	}

	public function down()
	{
		$this->alterColumn('city', 'spellings', 'text not null comment "дополнительные варианты написания"');
		$this->alterColumn('region', 'spellings', 'text not null comment "дополнительные варианты написания"');
		$this->dropColumn('city_lang', 'spellings');
		$this->dropColumn('region_lang', 'spellings');
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
