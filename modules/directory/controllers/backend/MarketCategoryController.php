<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.06.15
 * Time: 12:31
 */

namespace modules\directory\controllers\backend;


use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\directory\models\form\MarketCategoryForm;
use modules\directory\models\search\MarketCategorySearch;
use modules\directory\models\ShopCategory;
use modules\directory\models\ShopCategoryLang;
use modules\translations\models\Lang;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class MarketCategoryController extends ShopCategoryController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => MarketCategorySearch::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => ShopCategory::className(),
                'formModelClass' => MarketCategoryForm::className(),
                'redirectUrl' => Url::toRoute(['index']),
                'ajaxValidation' => true,
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => ShopCategory::className(),
                'formModelClass' => MarketCategoryForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute(['index']),
                'beforeAction' => function($model, $formModel){
                    $formModel->image = $model->image;

                    $languages = Lang::find()->all();
                    $scLangs = $model->shopCategoryLangs;
                    $scLangs = ArrayHelper::index($scLangs, 'lang_id');
                    foreach($languages as $language){
                        $scLang = isset($scLangs[$language->id]) ? $scLangs[$language->id] : new ShopCategoryLang();
                        $formModel->translationName[$language->id] = $scLang->name;
                        $formModel->translationDescription[$language->id] = $scLang->description;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                },
            ],
        ];
    }
} 