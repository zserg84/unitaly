<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_103820_drop_occupancy extends Migration
{
    public function up()
    {
        $this->dropForeignKey("fk_occupancy_type_occupancy_sub_type", "occupancy_type");
        $this->dropTable("occupancy_type");
        $this->dropTable("occupancy_sub_type");
    }

    public function down()
    {
        echo "m150619_103820_drop_occupancy cannot be reverted.\n";

        return false;
    }

}
