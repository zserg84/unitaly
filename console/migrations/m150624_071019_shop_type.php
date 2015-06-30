<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_071019_shop_type extends Migration
{
    public function up()
    {
        $this->createTable('shop_type', [
            'id' => 'pk',
            'image_id' => Schema::TYPE_INTEGER,
        ]);
        $this->addForeignKey('shop_type_image_id__image_id', 'shop_type', 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('shop_type');
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
