<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_120240_shop_alter extends Migration
{
    public function up()
    {
        $this->dropColumn('shop', 'description');
        $this->dropColumn('shop', 'short_description');

        $this->addColumn('shop_lang', 'description', Schema::TYPE_TEXT);
        $this->addColumn('shop_lang', 'short_description', Schema::TYPE_TEXT);
    }

    public function down()
    {
        echo "m150624_120240_shop_alter cannot be reverted.\n";

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
