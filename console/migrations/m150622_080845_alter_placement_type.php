<?php

use yii\db\Schema;
use yii\db\Migration;

class m150622_080845_alter_placement_type extends Migration
{
    public function up()
    {
        $this->addForeignKey('fk_placement_type_image_id__image_id', 'placement_type', 'image_id', 'image', 'id', 'CASCADE', 'CASCADE');
        $this->dropForeignKey("fk_restaurant_hotel", "restaurant");
        $this->dropForeignKey("fk_placement_type___placement_sub_type", "placement_type");
        $this->dropTable("hotel");
    }

    public function down()
    {
        $this->dropForeignKey("fk_placement_type_image_id__image_id", "placement_type");
    }

}
