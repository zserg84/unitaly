<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_044553_alter_restaurant extends Migration
{
    public function up()
    {
        $this->dropForeignKey("fk_restaurant___restaurant_type", "restaurant");
        $this->dropForeignKey("fk_restaurant_city", "restaurant");
        $this->dropForeignKey("fk_restaurant_region", "restaurant");

        $this->addForeignKey("fk_restaurant_restaurant_type_id__restaurant_type_id", "restaurant", "restaurant_type_id", "restaurant", "id", "RESTRICT", "CASCADE");
        $this->addForeignKey("fk_restaurant_city_id__city_id", "restaurant", "city_id", "city", "id", "RESTRICT", "CASCADE");
        $this->addForeignKey("fk_restaurant_region_id__region_id", "restaurant", "region_id", "region", "id", "RESTRICT", "CASCADE");
        $this->addForeignKey("fk_restaurant_logo_image_id__image_id", "restaurant", "logo_image_id", "image", "id", "SET NULL", "SET NULL");
        $this->addForeignKey("fk_restaurant_menu_image_id__image_id", "restaurant", "menu_image_id", "image", "id", "SET NULL", "SET NULL");
    }

    public function down()
    {
        $this->dropForeignKey("fk_restaurant_menu_image_id__image_id", "restaurant");
        $this->dropForeignKey("fk_restaurant_logo_image_id__image_id", "restaurant");
        $this->dropForeignKey("fk_restaurant_region_id__region_id", "restaurant");
        $this->dropForeignKey("fk_restaurant_city_id__city_id", "restaurant");
        $this->dropForeignKey("fk_restaurant_restaurant_type_id__restaurant_type_id", "restaurant");
    }
}
