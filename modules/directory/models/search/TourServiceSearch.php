<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 16.06.15
 * Time: 16:04
 */

namespace modules\directory\models\search;

use modules\directory\Module as DirectoryModule;
use modules\directory\models\AdditionalService;
use modules\directory\models\TourService;
use yii\helpers\VarDumper;

class TourServiceSearch extends AdditionalService
{
    public $tourId;

    public function getTourService(){
        return TourService::find()->where([
            'service_id' => $this->id,
            'tour_id' => $this->tourId,
        ])->one();
    }

    public function getTourInclude(){
        $tourService = $this->getTourService();
        return $tourService ? $tourService->include : 0;
    }

    public function getTourPrice(){
        $tourService = $this->getTourService();
        return $tourService ? $tourService->price : null;
    }

    public function getTourActive(){
        $tourService = $this->getTourService();
        return $tourService ? $tourService->active : 0;
    }

    public function attributeLabels(){
        return [
            'tourInclude' => DirectoryModule::t('tour', 'INCLUDE'),
            'tourActive' => DirectoryModule::t('tour', 'ACTIVE'),
            'tourPrice' => DirectoryModule::t('tour', 'PRICE'),
            'name' => DirectoryModule::t('tour', 'SERVICE_NAME'),
        ];
    }
} 