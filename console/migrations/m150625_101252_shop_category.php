<?php

use yii\db\Schema;
use yii\db\Migration;

class m150625_101252_shop_category extends Migration
{
    public function up()
    {
        $this->createTable('shop_category', [
            'id' => 'pk',
            'image_id' => Schema::TYPE_INTEGER,
        ]);
        $this->addForeignKey('fk_shop_category_image_id__image_id', 'shop_category', 'image_id', 'image', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('shop_category');
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
