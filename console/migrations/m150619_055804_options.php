<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_055804_options extends Migration
{
    public function up()
    {
	    $this->dropForeignKey('fk_placement_option_lang_placement_option__placement_option_id', 'placement_option_lang');
	    $this->dropForeignKey('fk_placement_option_lang_lang_id__lang_id', 'placement_option_lang');
	    $this->dropTable('placement_option_lang');
	    $this->dropForeignKey('fk_placement_option_image_id__image_id', 'placement_option');
	    $this->dropIndex('uidx_placement_option_identifier', 'placement_option');
	    $this->dropTable('placement_option');
    }

    public function down()
    {
        echo "m150619_055804_options cannot be reverted.\n";

        return false;
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
