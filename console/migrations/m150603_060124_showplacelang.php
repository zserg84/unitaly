<?php

use yii\db\Schema;
use yii\db\Migration;

class m150603_060124_showplacelang extends Migration
{
    public function up()
    {
        $this->createTable('showplace_lang', [
            'id' => 'pk',
            'showplace_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . '(100) NOT NULL',
        ]);
        $this->addForeignKey('fk_showplace_lang_showplace_id__showplace_id', 'showplace_lang', 'showplace_id', 'showplace', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_showplace_lang_lang_id__lang_id', 'showplace_lang', 'lang_id', 'lang', 'id', 'CASCADE', 'CASCADE');

        $this->dropColumn('showplace', 'region_id');
        $this->addForeignKey('fk_showplace_city_id__city_id', 'showplace', 'city_id', 'city', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('showplace_lang');
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
