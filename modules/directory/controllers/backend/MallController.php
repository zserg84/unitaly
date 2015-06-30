<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 25.06.15
 * Time: 15:39
 */

namespace modules\directory\controllers\backend;


use common\actions\CreateAction;
use common\actions\UpdateAction;
use modules\directory\models\form\ShopMallForm;
use modules\directory\models\Shop;
use yii\helpers\Url;

class MallController extends ShopController
{

    public function actions(){
        return [
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Shop::className(),
                'formModelClass' => ShopMallForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('shop/index'),
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Shop::className(),
                'formModelClass' => ShopMallForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('shop/index'),
                'beforeAction' => function($model, $formModel){
                    return $this->beforeUpdate($model, $formModel);
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
        ];
    }
} 