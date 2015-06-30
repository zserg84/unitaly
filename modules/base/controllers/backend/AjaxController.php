<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 03.06.15
 * Time: 10:46
 */

namespace modules\base\controllers\backend;

use modules\directory\models\City;
use modules\directory\models\Province;
use vova07\admin\components\Controller;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class AjaxController extends Controller
{

    public function actionGetProvinces(){
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $regionId = $parents[0];
                $provinces = Province::find();
                $provinces->where(['region_id'=>$regionId]);
                $provinces = $provinces->all();
                $out = [];
                foreach($provinces as $k=>$province){
                    $out[$k] = [
                        'id' => $province->id,
                        'name' => $province->name,
                    ];
                }
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionGetCities(){
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $regionId = $parents[0];
                $provinceId = $parents[1];
                $cities = City::find();
                if($provinceId){
                    $cities->where(['province_id'=>$provinceId]);
                }
                else{
                    $cities->innerJoinWith([
                        'provinces' => function($query) use($regionId){
                            $query->where([
                                'province.region_id' => $regionId,
                            ]);
                        }
                    ]);
                }
                $cities = $cities->all();
                $out = [];
                foreach($cities as $k=>$city){
                    $out[$k] = [
                        'id' => $city->id,
                        'name' => $city->name,
                    ];
                }
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionGetPlacementSubTypes()
    {
        // решаемо после задачи подтипов размещения
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
} 