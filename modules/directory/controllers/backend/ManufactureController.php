<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 29.06.15
 * Time: 16:51
 */

namespace modules\directory\controllers\backend;


use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\directory\models\City;
use modules\directory\models\form\ManufactureForm;
use modules\directory\models\Manufacture;
use modules\directory\models\ManufactureLang;
use modules\directory\models\Province;
use modules\directory\models\search\ManufactureSearch;
use modules\image\models\Image;
use modules\translations\models\Lang;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

class ManufactureController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['BViewManufacture']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateManufacture']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update', 'image-delete'],
            'roles' => ['BUpdateManufacture']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteManufacture']
        ];

        return $behaviors;
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => ManufactureSearch::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Manufacture::className(),
                'formModelClass' => ManufactureForm::className(),
                'redirectUrl' => Url::toRoute(['index']),
                'ajaxValidation' => true,
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Manufacture::className(),
                'formModelClass' => ManufactureForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute(['index']),
                'beforeAction' => function($model, $formModel){
                    $formModel->image = $model->image;

                    $city = City::findOne($formModel->city_id);
                    if($city){
                        $formModel->province_id = $city->province_id;
                        $province = Province::findOne($city->province_id);
                        $formModel->region_id = $province->region_id;
                    }

                    $languages = Lang::find()->all();
                    $manLangs = $model->manufactureLangs;
                    $manLangs = ArrayHelper::index($manLangs, 'lang_id');
                    foreach($languages as $language){
                        $manLang = isset($manLangs[$language->id]) ? $manLangs[$language->id] : new ManufactureLang();
                        $formModel->translationName[$language->id] = $manLang->name;
                        $formModel->translationSpellings[$language->id] = $manLang->spellings;
                        $formModel->translationMediafaceName[$language->id] = $manLang->mediaface_name;
                        $formModel->translationWorktime[$language->id] = $manLang->worktime;
                    }

                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                },
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Manufacture::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => Manufacture::className(),
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
        $image = $formModel->getImageModel('image');
        if($image){
            $model->image_id = $image->id;
            $model->save();
        }

        $model->saveLangsRelations('manufactureLangs', $formModel, 'translationName', 'name', 'manufacture_id');
        $model->saveLangsRelations('manufactureLangs', $formModel, 'translationSpellings', 'spellings', 'manufacture_id');
        $model->saveLangsRelations('manufactureLangs', $formModel, 'translationMediafaceName', 'mediaface_name', 'manufacture_id');
        $model->saveLangsRelations('manufactureLangs', $formModel, 'translationWorktime', 'worktime', 'manufacture_id');

        return $model;
    }
} 