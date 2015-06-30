<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 22.06.15
 * Time: 17:35
 */

namespace modules\directory\models\search;

use modules\directory\models\AdditionalService;
use modules\directory\Module as DirectoryModule;
use modules\directory\models\CafeService;

class CafeServiceSearch extends AdditionalService
{
    public $cafeId;

    public function getCafeService(){
        return CafeService::find()->where([
            'service_id' => $this->id,
            'cafe_id' => $this->cafeId,
        ])->one();
    }

    public function getCafePrice(){
        $cafeService = $this->getCafeService();
        return $cafeService ? $cafeService->price : null;
    }

    public function getCafeActive(){
        $cafeService = $this->getCafeService();
        return $cafeService ? $cafeService->active : 0;
    }

    public function attributeLabels(){
        return [
            'cafeActive' => DirectoryModule::t('cafe', 'ACTIVE'),
            'cafePrice' => DirectoryModule::t('cafe', 'PRICE'),
            'name' => DirectoryModule::t('cafe', 'SERVICE_NAME'),
        ];
    }
} 