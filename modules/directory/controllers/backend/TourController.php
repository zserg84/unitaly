<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 10.06.15
 * Time: 15:41
 */

namespace modules\directory\controllers\backend;


use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\UpdateAction;
use modules\directory\models\City;
use modules\directory\models\form\TourForm;
use modules\directory\models\form\TourServiceForm;
use modules\directory\models\Province;
use modules\directory\models\search\TourSearch;
use modules\directory\models\search\TourServiceSearch;
use modules\directory\models\ServiceType;
use modules\directory\models\Tour;
use modules\directory\models\TourLang;
use modules\directory\models\TourService;
use modules\image\models\Image;
use modules\translations\models\Lang;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

class TourController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['BViewTour']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateTour']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update', 'image-delete'],
            'roles' => ['BUpdateTour']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteTour']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['service'],
            'roles' => ['BServiceTour']
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
                'modelClass' => Tour::className(),
                'formModelClass' => TourForm::className(),
                'redirectUrl' => Url::toRoute(['index']),
                'ajaxValidation' => true,
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Tour::className(),
                'formModelClass' => TourForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute(['index']),
                'beforeAction' => function($model, $formModel){
                    $formModel->image = $model->image;
                    $formModel->additional_image = $model->additionalImage;

                    $city = City::findOne($formModel->city_id);
                    if($city){
                        $formModel->province_id = $city->province_id;
                        $province = Province::findOne($city->province_id);
                        $formModel->region_id = $province->region_id;
                    }

                    $languages = Lang::find()->all();
                    $tourLangs = $model->tourLangs;
                    $tourLangs = ArrayHelper::index($tourLangs, 'lang_id');
                    foreach($languages as $language){
                        $tourLang = isset($tourLangs[$language->id]) ? $tourLangs[$language->id] : new TourLang();
                        $formModel->translationName[$language->id] = $tourLang->name;
                    }

                    $formModel->date_start = $formModel->date_start ? \Yii::$app->getFormatter()->asDate($formModel->date_start) : null;

                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                },
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Tour::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => Tour::className(),
            ],
            'image-delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Image::className(),
                'modelIdName' => 'key',
                'redirectUrl' => false,
            ],
        ];
    }

    public function actionIndex(){
        $searchModel = new TourSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function afterEdit($action, $model, $formModel){
        $formModel->image = UploadedFile::getInstance($formModel, 'image');
        $image = $formModel->getImage('image');
        if($image){
            $model->image_id = $image->id;
            $model->save();
        }
        $formModel->additional_image = UploadedFile::getInstance($formModel, 'additional_image');
        $image = $formModel->getImage('additional_image');
        if($image){
            $model->additional_image_id = $image->id;
            $model->save();
        }

        $model->saveLangsRelations('tourLangs', $formModel, 'translationName', 'name', 'tour_id');

        return $model;
    }

    public function actionService($tourId){
        $types = ServiceType::find()->tour()->all();

        $curTypeId = \Yii::$app->getRequest()->get('type');
        reset($types);
        if(!$curTypeId && $curType = current($types)){
            $curTypeId = $curType->id;
        }

        $model = new TourServiceForm();
        $model->serviceTypeId = $curTypeId;
        $model->tourId = $tourId;
        $serviceDataProvider = $model->search();

        if($post = \Yii::$app->request->post('TourServiceSearch')){
            $count = 0;
            foreach($post as $service_id=>$attrs){
                $ts = TourService::find()->where([
                    'tour_id' => $tourId,
                    'service_id' => $service_id
                ])->one();
                $ts = $ts ? $ts : new TourService();
                $ts->tour_id = $tourId;
                $ts->service_id = $service_id;
                $ts->include = $post[$service_id]['tourInclude'];
                $ts->price = $post[$service_id]['tourPrice'];
                $ts->active = $post[$service_id]['tourActive'];
                if($ts->load($attrs, '')){
                    if ($ts->save()) {
                        $count++;
                    }
                }
            }
//            \Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
//            return $this->redirect(['index']); // redirect to your next desired page
        }
        return $this->render('service', [
            'tourId' => $tourId,
            'types' => $types,
            'curTypeId' => $curTypeId,
            'dataProvider' => $serviceDataProvider,
        ]);
    }

    public function findModel($id){
        return parent::_findModel(Tour::className(), $id);
    }
} 