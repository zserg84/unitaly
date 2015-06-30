<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 22.06.15
 * Time: 13:05
 */

namespace modules\directory\controllers\backend;


use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\directory\models\Cafe;
use modules\directory\models\CafeLang;
use modules\directory\models\CafeService;
use modules\directory\models\City;
use modules\directory\models\form\CafeForm;
use modules\directory\models\form\CafeServiceForm;
use modules\directory\models\Province;
use modules\directory\models\search\CafeSearch;
use modules\directory\models\ServiceType;
use modules\image\models\Image;
use modules\translations\models\Lang;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

class CafeController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['BViewCafe']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateCafe']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update', 'image-delete'],
            'roles' => ['BUpdateCafe']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteCafe']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['service'],
            'roles' => ['BServiceCafe']
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
                'modelClass' => CafeSearch::className(),
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Cafe::className(),
                'formModelClass' => CafeForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel) {
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Cafe::className(),
                'formModelClass' => CafeForm::className(),
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel){
                    $formModel->logo_image = $model->logoImage;
                    $city = City::findOne($formModel->city_id);
                    if($city){
                        $formModel->province_id = $city->province_id;
                        $province = Province::findOne($city->province_id);
                        $formModel->region_id = $province->region_id;
                    }

                    $languages = Lang::find()->all();
                    $cafeLangs = $model->cafeLangs;
                    $cafeLangs = ArrayHelper::index($cafeLangs, 'lang_id');
                    foreach($languages as $language){
                        $cafeLang = isset($cafeLangs[$language->id]) ? $cafeLangs[$language->id] : new CafeLang();
                        $formModel->translationName[$language->id] = $cafeLang->name;
                        $formModel->translationSpellings[$language->id] = $cafeLang->spellings;
                        $formModel->translationWorktime[$language->id] = $cafeLang->worktime;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Cafe::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => Cafe::className(),
            ],
            'image-delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Image::className(),
                'modelIdName' => 'key',
                'redirectUrl' => false,
            ],
        ];
    }

    public function afterEdit($action, $model, $formModel)
    {
        $formModel->logo_image = UploadedFile::getInstance($formModel, 'logo_image');
        if ($image = $formModel->getImage('logo_image')) {
            $model->logo_image_id = $image->id;
            $model->save();
        }

        $model->saveLangsRelations('cafeLangs', $formModel, 'translationName', 'name', 'cafe_id');
        $model->saveLangsRelations('cafeLangs', $formModel, 'translationSpellings', 'spellings', 'cafe_id');
        $model->saveLangsRelations('cafeLangs', $formModel, 'translationWorktime', 'worktime', 'cafe_id');

        return $model;
    }

    public function actionService($cafeId){
        $type = ServiceType::find()->cafe()->one();
        $curTypeId = $type->id;

        $model = new CafeServiceForm();
        $model->serviceTypeId = $curTypeId;
        $model->cafeId = $cafeId;
        $serviceDataProvider = $model->search();

        if($post = \Yii::$app->request->post('CafeServiceSearch')){
            $count = 0;
            foreach($post as $service_id=>$attrs){
                $cs = CafeService::find()->where([
                    'cafe_id' => $cafeId,
                    'service_id' => $service_id
                ])->one();
                $cs = $cs ? $cs : new CafeService();
                $cs->cafe_id = $cafeId;
                $cs->service_id = $service_id;
                $cs->price = $post[$service_id]['cafePrice'];
                $cs->active = $post[$service_id]['cafeActive'];
                if($cs->load($attrs, '')){
                    if ($cs->save()) {
                        $count++;
                    }
                }
            }
//            \Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
//            return $this->redirect(['index']); // redirect to your next desired page
        }
        return $this->render('service', [
            'cafeId' => $cafeId,
            'type' => $type,
            'dataProvider' => $serviceDataProvider,
        ]);
    }
} 