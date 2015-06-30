<?php

use yii\db\Schema;
use yii\db\Migration;

class m150616_054823_alter_restaurants extends Migration
{
    public function up()
    {
        $this->createTable('restaurant_type', [
            'id' => 'pk',
        ]);
        $this->addColumn('restaurant', 'restaurant_type_id', Schema::TYPE_INTEGER);
        $this->addForeignKey('fk_restaurant___restaurant_type', 'restaurant', 'restaurant_type_id', 'restaurant_type', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_restaurant___restaurant_type', 'restaurant');
        $this->dropColumn('restaurant', 'restaurant_type_id');
        $this->dropTable('restaurant_type');
    }

}
