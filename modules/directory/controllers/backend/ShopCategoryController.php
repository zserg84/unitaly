<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 26.06.15
 * Time: 11:24
 */

namespace modules\directory\controllers\backend;


use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\directory\models\form\ShopCategoryForm;
use modules\directory\models\search\ShopCategorySearch;
use modules\directory\models\ShopCategory;
use modules\directory\models\ShopCategoryLang;
use modules\image\models\Image;
use modules\translations\models\Lang;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

class ShopCategoryController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['BViewShopCategory']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateShopCategory']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update', 'image-delete'],
            'roles' => ['BUpdateShopCategory']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteShopCategory']
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'create' => ['get', 'post'],
                'update' => ['get', 'put', 'post'],
                'delete' => ['post', 'delete'],
            ]
        ];

        return $behaviors;
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => ShopCategorySearch::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => ShopCategory::className(),
                'formModelClass' => ShopCategoryForm::className(),
                'redirectUrl' => Url::toRoute(['index']),
                'ajaxValidation' => true,
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => ShopCategory::className(),
                'formModelClass' => ShopCategoryForm::className(),
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
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => ShopCategory::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => ShopCategory::className(),
            ],
            'image-delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Image::className(),
                'modelIdName' => 'key',
                'redirectUrl' => false,
            ],
        ];
    }

    public function afterEdit($action, $model, $formModel){
        $formModel->image = UploadedFile::getInstance($formModel, 'image');
        $image = $formModel->getImage('image');
        if($image){
            $model->image_id = $image->id;
            $model->save();
        }

        $model->saveLangsRelations('shopCategoryLangs', $formModel, 'translationName', 'name', 'shop_category_id');
        $model->saveLangsRelations('shopCategoryLangs', $formModel, 'translationDescription', 'description', 'shop_category_id');

        return $model;
    }
} 