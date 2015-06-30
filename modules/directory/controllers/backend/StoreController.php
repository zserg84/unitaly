<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 25.06.15
 * Time: 16:12
 */

namespace modules\directory\controllers\backend;


use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\UpdateAction;
use modules\directory\models\form\ShopStoreForm;
use modules\directory\models\Shop;
use modules\image\models\Image;
use yii\helpers\Url;

class StoreController extends ShopController
{

    public function actions()
    {
        return [
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Shop::className(),
                'formModelClass' => ShopStoreForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('shop/index'),
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Shop::className(),
                'formModelClass' => ShopStoreForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('shop/index'),
                'beforeAction' => function($model, $formModel){
                    return $this->beforeUpdate($model, $formModel);
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'image-delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Image::className(),
                'modelIdName' => 'key',
                'redirectUrl' => false,
            ],
        ];
    }
} 