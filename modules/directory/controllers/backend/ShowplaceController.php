<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 01.06.15
 * Time: 15:01
 */

namespace modules\directory\controllers\backend;


use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\UpdateAction;
use modules\base\behaviors\LangSaveBehavior;
use modules\base\widgets\alphabet\AlphabetListView;
use modules\directory\models\City;
use modules\directory\models\form\ShowplaceForm;
use modules\directory\models\Province;
use modules\directory\models\search\ShowplaceSearch;
use modules\directory\models\Showplace;
use modules\directory\models\ShowplaceLang;
use modules\directory\Module;
use modules\image\models\Image;
use modules\translations\models\Lang;
use vova07\users\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

class ShowplaceController extends Controller
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
                'roles' => ['BViewShowplace']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create', 'image-delete'],
            'roles' => ['BCreateShowplace']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update', 'image-delete'],
            'roles' => ['BUpdateShowplace']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteShowplace']
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
                'modelClass' => Showplace::className(),
                'formModelClass' => ShowplaceForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Showplace::className(),
                'formModelClass' => ShowplaceForm::className(),
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
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
                    $showplaceLangs = $model->showplaceLangs;
                    $showplaceLangs = ArrayHelper::index($showplaceLangs, 'lang_id');
                    foreach($languages as $language){
                        $showplaceLang = isset($showplaceLangs[$language->id]) ? $showplaceLangs[$language->id] : new ShowplaceLang();
                        $formModel->translationName[$language->id] = $showplaceLang->name;
                        $formModel->translationShortDescription[$language->id] = $showplaceLang->short_description;
                        $formModel->translationDescription[$language->id] = $showplaceLang->description;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Showplace::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => Showplace::className(),
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

        $formModel->additional_image = UploadedFile::getInstance($formModel, 'additional_image');
        $image = $formModel->getImage('additional_image');
        if($image){
            $model->additional_image_id = $image->id;
            $model->save();
        }

        $model->saveLangsRelations('showplaceLangs', $formModel, 'translationName', 'name', 'showplace_id');
        $model->saveLangsRelations('showplaceLangs', $formModel, 'translationShortDescription', 'short_description', 'showplace_id');
        $model->saveLangsRelations('showplaceLangs', $formModel, 'translationDescription', 'description', 'showplace_id');

        return $model;
    }

    public function actionIndex(){
        $searchModel = new ShowplaceSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
} 