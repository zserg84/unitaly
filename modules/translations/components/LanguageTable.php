<?php
namespace modules\translations\components;
use yii\db\Schema;

trait LanguageTable {
	public function createLang()
	{
		if (!isset($this->tableName)) {
			echo 'не указано название исходной таблицы. добавьте public $tableName = \'название таблицы\';';
			return false;
		}
		$fields = (!isset($this->additionalFields)) ? [] : $this->additionalFields;
		$this->createTable($this->tableName . '_lang', [
			'id' => 'pk',
			$this->tableName . '_id' => Schema::TYPE_INTEGER . ' NOT NULL',
			'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
			'name' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
		] + $fields);

        $addFk = isset($this->addFK) ? $this->addFK : true;

        if($addFk){
            $this->addForeignKey('fk_' .$this->tableName . '_lang_' .$this->tableName . '_id__' .$this->tableName . '_id', $this->tableName . '_lang', $this->tableName . '_id', $this->tableName, 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('fk_' .$this->tableName . '_lang_lang_id__lang_id', $this->tableName . '_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');
        }
		return true;
	}
	public function deleteLang()
	{
		if (!isset($this->tableName)) {
			echo 'не указано название исходной таблицы. добавьте public $tableName = \'название таблицы\';';
			return false;
		}
        $addFk = isset($this->addFK) ? $this->addFK : true;
        if($addFk){
            $this->dropForeignKey('fk_' .$this->tableName . '_lang_' .$this->tableName . '_id__' .$this->tableName . '_id', $this->tableName . '_lang');
            $this->dropForeignKey('fk_' .$this->tableName . '_lang_lang_id__lang_id', $this->tableName . '_lang');
        }
		$this->dropTable($this->tableName . '_lang');
		return true;
	}
}