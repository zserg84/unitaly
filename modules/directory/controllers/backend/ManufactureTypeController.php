<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 30.06.15
 * Time: 10:26
 */

namespace modules\directory\controllers\backend;


use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\directory\models\form\ManufactureTypeForm;
use modules\directory\models\ManufactureType;
use modules\directory\models\ManufactureTypeLang;
use modules\directory\models\search\ManufactureTypeSearch;
use modules\image\models\Image;
use modules\translations\models\Lang;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ManufactureTypeController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['BViewManufactureType']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateManufactureType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update', 'image-delete'],
            'roles' => ['BUpdateManufactureType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteManufactureType']
        ];

        return $behaviors;
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => ManufactureTypeSearch::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => ManufactureType::className(),
                'formModelClass' => ManufactureTypeForm::className(),
                'redirectUrl' => Url::toRoute(['index']),
                'ajaxValidation' => true,
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => ManufactureType::className(),
                'formModelClass' => ManufactureTypeForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute(['index']),
                'beforeAction' => function($model, $formModel){
                    $formModel->image = $model->image;

                    $languages = Lang::find()->all();
                    $manTypeLangs = $model->manufactureTypeLangs;
                    $manTypeLangs = ArrayHelper::index($manTypeLangs, 'lang_id');
                    foreach($languages as $language){
                        $manTypeLang = isset($manTypeLangs[$language->id]) ? $manTypeLangs[$language->id] : new ManufactureTypeLang();
                        $formModel->translationName[$language->id] = $manTypeLang->name;
                        $formModel->translationDescription[$language->id] = $manTypeLang->spellings;
                    }

                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                },
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => ManufactureType::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => ManufactureType::className(),
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
        $model->saveLangsRelations('manufactureTypeLangs', $formModel, 'translationName', 'name', 'manufacture_type_id');
        $model->saveLangsRelations('manufactureTypeLangs', $formModel, 'translationDescription', 'description', 'manufacture_type_id');

        return $model;
    }
} 