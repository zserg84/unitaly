<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 16.06.15
 * Time: 15:42
 */

namespace modules\directory\models\form;


use modules\directory\models\search\AdditionalServiceSearch;
use modules\directory\models\search\TourServiceSearch;
use modules\directory\models\TourService;
use yii\data\ActiveDataProvider;

class TourServiceForm extends TourService
{

    public $serviceTypeId;

    public $tourId;

    public function search(){
        $query = TourServiceSearch::find()->where([
            'service_type_id' => $this->serviceTypeId
        ]);
        $query->indexBy('id');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
} 