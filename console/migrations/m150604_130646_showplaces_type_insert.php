<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_130646_showplaces_type_insert extends Migration
{
    public function up()
    {
        $types = [
            ['памятник', 'скульптура'],
            ['музей'],
            ['галерея живописи, фотографии'],
            ['городской парк'],
            ['национальный парк/заповедник'],
            ['площадь'],
            ['городской район'],
            ['парк развлечений'],
            ['объект архитектуры', 'дворец, замок, мост'],
            ['религиозный объект'],
            ['театр'],
            ['порт'],
            ['историческое место'],
            ['канал'],
            ['природный объект', 'водопад, гора/скала, местность .. и прочие красоты'],
        ];
        foreach($types as $k=>$type){
            $this->insert('showplace_type', [
                'identifier' => $k+1,
                'name' => $type[0],
                'description' => isset($type[1])  ? $type[1] : '',
            ]);
//            $lastId = $this->execute('SELECT LAST_INSERT_ID()');
//            echo $lastId;
            $this->execute('INSERT INTO showplace_type_lang(showplace_type_id, lang_id, name, description)
              SELECT st.id as showplace_type_id, l.id as lang_id, :name, :description
                FROM showplace_type st
                  INNER JOIN lang l ON l.url = "ru"
                WHERE identifier = :identifier
                LIMIT 1
            ',[
                'name' => $type[0],
                'description' =>  isset($type[1])  ? $type[1] : '',
                'identifier' => $k+1
            ]);

        }
    }

    public function down()
    {
        $this->delete('showplace_type_lang');
        $this->delete('showplace_type');
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
