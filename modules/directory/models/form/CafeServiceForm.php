<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 22.06.15
 * Time: 17:35
 */

namespace modules\directory\models\form;


use modules\directory\models\CafeService;
use modules\directory\models\search\CafeServiceSearch;
use yii\data\ActiveDataProvider;

class CafeServiceForm extends CafeService
{

    public $serviceTypeId;

    public $cafeId;

    public function search(){
        $query = CafeServiceSearch::find()->where([
            'service_type_id' => $this->serviceTypeId
        ]);
        $query->indexBy('id');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
} 