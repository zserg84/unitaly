<?php

namespace modules\directory\controllers\backend;

use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\UpdateAction;
use modules\base\behaviors\LangSaveBehavior;
use modules\base\widgets\alphabet\AlphabetListView;
use modules\directory\models\Restaurant;
use modules\directory\models\form\RestaurantForm;
use modules\directory\models\RestaurantLang;
use modules\directory\Module;
use modules\translations\models\Lang;
use vova07\users\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\db\ActiveRecord;
use modules\directory\models\search\RestaurantSearch;
use modules\directory\models\Province;
use modules\directory\models\City;


class RestaurantController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['index'],
            'roles' => ['BViewRestaurant']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateRestaurant']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update'],
            'roles' => ['BUpdateRestaurant']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete'],
            'roles' => ['BDeleteRestaurant']
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
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Restaurant::className(),
                'formModelClass' => RestaurantForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel) {
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Restaurant::className(),
                'formModelClass' => RestaurantForm::className(),
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel) {
                    $formModel->menu_image = $model->menuImage;
                    $formModel->logo_image = $model->logoImage;

                    $city = City::findOne($formModel->city_id);
                    if($city){
                        $formModel->province_id = $city->province_id;
                        $province = Province::findOne($city->province_id);
                        $formModel->region_id = $province->region_id;
                    }

                    $languages = Lang::find()->all();
                    $restaurantLangs = $model->restaurantLangs;
                    $restaurantLangs = ArrayHelper::index($restaurantLangs, 'lang_id');
                    foreach($languages as $language) {
                        $restaurantLang = isset($restaurantLangs[$language->id]) ? $restaurantLangs[$language->id] : new RestaurantLang();
                        $formModel->translationName[$language->id] = $restaurantLang->name;
                        $formModel->translationWorktime[$language->id] = $restaurantLang->worktime;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Restaurant::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
        ];
    }

    /**
     * Index
     */
    public function actionIndex($q=null)
    {
        $searchModel = new RestaurantSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * After edit
     */
    public function afterEdit($action, $model, $formModel)
    {
        $formModel->logo_image = UploadedFile::getInstance($formModel, 'logo_image');
        if ($image = $formModel->getImage('logo_image')) {
            $model->logo_image_id = $image->id;
            $model->save();
        }
        $formModel->menu_image = UploadedFile::getInstance($formModel, 'menu_image');
        if ($image = $formModel->getImage('menu_image')) {
            $model->menu_image_id = $image->id;
            $model->save();
        }

        $model->saveLangsRelations('restaurantLangs', $formModel, 'translationName', 'name', 'restaurant_id');
        $model->saveLangsRelations('restaurantLangs', $formModel, 'translationWorktime', 'worktime', 'restaurant_id');
        $model->trigger(ActiveRecord::EVENT_AFTER_FIND);
        $firstLetter = mb_substr($model->name,0,1,'utf-8');
        $action->redirectUrl = Url::toRoute(['index', 'q'=>$firstLetter]);
        return $model;
    }
}