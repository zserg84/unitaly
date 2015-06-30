<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 19.06.15
 * Time: 13:57
 */

namespace modules\directory\controllers\backend;


use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\directory\models\form\ProvinceForm;
use modules\directory\models\Province;
use modules\directory\models\ProvinceLang;
use modules\directory\models\search\ProvinceSearch;
use modules\image\models\Image;
use modules\translations\models\Lang;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

class ProvinceController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['BViewProvince']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateProvince']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update', 'image-delete'],
            'roles' => ['BUpdateProvince']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteProvince']
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
                'modelClass' => ProvinceSearch::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Province::className(),
                'formModelClass' => ProvinceForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Province::className(),
                'formModelClass' => ProvinceForm::className(),
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel){
                    $formModel->visit_image = $model->visitImage;
                    $formModel->flag_image = $model->flagImage;
                    $formModel->arms_image = $model->armsImage;

                    $languages = Lang::find()->all();
                    $provinceLangs = $model->provinceLangs;
                    $provinceLangs = ArrayHelper::index($provinceLangs, 'lang_id');
                    foreach($languages as $language){
                        $provinceLang = isset($provinceLangs[$language->id]) ? $provinceLangs[$language->id] : new ProvinceLang();
                        $formModel->translationName[$language->id] = $provinceLang->name;
                        $formModel->translationDescription[$language->id] = $provinceLang->description;
                        $formModel->translationSpellings[$language->id] = $provinceLang->spellings;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Province::className(),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => Province::className(),
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
        $formModel->visit_image = UploadedFile::getInstance($formModel, 'visit_image');
        if ($image = $formModel->getImage('visit_image')) {
            $model->visit_image_id = $image->id;
            $model->save();
        }
        $formModel->flag_image = UploadedFile::getInstance($formModel, 'flag_image');
        if ($image = $formModel->getImage('flag_image')) {
            $model->flag_image_id = $image->id;
            $model->save();
        }
        $formModel->arms_image = UploadedFile::getInstance($formModel, 'arms_image');
        if ($image = $formModel->getImage('arms_image')){
            $model->arms_image_id = $image->id;
            $model->save();
        }
        $model->saveLangsRelations('provinceLangs', $formModel, 'translationName', 'name', 'province_id');
        $model->saveLangsRelations('provinceLangs', $formModel, 'translationDescription', 'description', 'province_id');
        $model->saveLangsRelations('provinceLangs', $formModel, 'translationSpellings', 'spellings', 'province_id');

        return $model;
    }

} 