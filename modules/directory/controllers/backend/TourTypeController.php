<?php

namespace modules\directory\controllers\backend;


use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\UpdateAction;
use modules\directory\models\form\TourTypeForm;
use modules\directory\models\search\TourTypeSearch;
use modules\directory\models\TourType;
use modules\directory\models\TourTypeLang;
use modules\image\models\Image;
use modules\translations\models\Lang;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

class TourTypeController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['BViewTourType']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateTourType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update', 'image-delete'],
            'roles' => ['BUpdateTourType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteTourType']
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'create' => ['get', 'post'],
                'update' => ['get', 'put', 'post'],
                'delete' => ['post', 'delete'],
                'batch-delete' => ['post', 'delete'],
            ]
        ];

        return $behaviors;
    }

    public function actions()
    {
        return [
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => TourType::className(),
                'formModelClass' => TourTypeForm::className(),
                'redirectUrl' => Url::toRoute(['index']),
                'ajaxValidation' => true,
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => TourType::className(),
                'formModelClass' => TourTypeForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute(['index']),
                'beforeAction' => function($model, $formModel){
                    $formModel->image = $model->image;

                    $languages = Lang::find()->all();
                    $tourTypeLangs = $model->tourTypeLangs;
                    $tourTypeLangs = ArrayHelper::index($tourTypeLangs, 'lang_id');
                    foreach($languages as $language){
                        $tourTypeLang = isset($tourTypeLangs[$language->id]) ? $tourTypeLangs[$language->id] : new TourTypeLang();
                        $formModel->translationName[$language->id] = $tourTypeLang->name;
                        $formModel->translationDescription[$language->id] = $tourTypeLang->description;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                },
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => TourType::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => TourType::className(),
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

        $model->saveLangsRelations('tourTypeLangs', $formModel, 'translationName', 'name', 'tour_type_id');
        $model->saveLangsRelations('tourTypeLangs', $formModel, 'translationDescription', 'description', 'tour_type_id');

        return $model;
    }

    public function actionIndex(){
        $searchModel = new TourTypeSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}