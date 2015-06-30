<?php

use yii\db\Schema;
use yii\db\Migration;

class m150626_101226_address_alter extends Migration
{
    public function up()
    {
        $tables = ['cafe', 'shop', 'showplace'];
        foreach($tables as $table){
            $tableLang = $table.'_lang';
            $relationField = $table.'_id';

            try{
                $this->addColumn($table, 'address', Schema::TYPE_STRING . '(255) AFTER city_id');
            }
            catch(\yii\base\Exception $e){

            }

            $this->execute('
                UPDATE '.$table.' INNER JOIN '.$tableLang.' ON '.$tableLang.'.'.$relationField.' = '.$table.'.id
                    SET '.$table.'.address = '.$tableLang.'.address
                    WHERE '.$tableLang.'.lang_id = 3
            ');

            $this->dropColumn($tableLang, 'address');

        }
//        $this->dropColumn('cafe_lang', 'address');
//
//        $this->dropColumn('shop_lang', 'address');
//        $this->addColumn('shop', 'address', Schema::TYPE_STRING . '(255) AFTER city_id');
//
//        $this->dropColumn('showplace_lang', 'address');
//        $this->addColumn('showplace', 'address', Schema::TYPE_STRING . '(255) AFTER city_id');

    }

    public function down()
    {
        echo "m150626_101226_address_alter cannot be reverted.\n";

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
