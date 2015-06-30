<?php

use yii\db\Schema;
use yii\db\Migration;

class m150616_113951_placement_options_lang extends Migration
{
    public function up()
    {
	    $this->createTable('placement_option_lang', [
		                                                   'id' => 'pk',
		                                                   'placement_option_id' => Schema::TYPE_INTEGER . ' NOT NULL',
		                                                   'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
		                                                   'name' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
		                                                   'description' => Schema::TYPE_TEXT . ' DEFAULT NULL',
	                                                   ]);
	    $this->addForeignKey(
		    'fk_placement_option_lang_placement_option__placement_option_id',
		    'placement_option_lang',
		    'placement_option_id', 'placement_option', 'id', 'CASCADE', 'CASCADE');
	    $this->addForeignKey('fk_placement_option_lang_lang_id__lang_id', 'placement_option_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropForeignKey('fk_placement_option_lang_placement_option__placement_option_id', 'placement_option_lang');
	    $this->dropForeignKey('fk_placement_option_lang_lang_id__lang_id', 'placement_option_lang');
	    $this->dropTable('placement_option_lang');
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
