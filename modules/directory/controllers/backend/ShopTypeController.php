<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 03.06.15
 * Time: 17:51
 */

namespace modules\directory\controllers\backend;

use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\UpdateAction;
use modules\base\behaviors\LangSaveBehavior;
use modules\base\widgets\alphabet\AlphabetListView;
use modules\directory\models\form\ShopTypeForm;
use modules\directory\models\search\ShopTypeSearch;
use modules\directory\models\ShopType;
use modules\directory\models\ShopTypeLang;
use modules\translations\models\Lang;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

class ShopTypeController extends Controller
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
                'roles' => ['BViewShopType']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateShopType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update'],
            'roles' => ['BUpdateShopType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteShopType']
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
                'modelClass' => ShopType::className(),
                'formModelClass' => ShopTypeForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => ShopType::className(),
                'formModelClass' => ShopTypeForm::className(),
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel){
                    $formModel->image = $model->image;

                    $languages = Lang::find()->all();
                    $shopTypeLangs = $model->shopTypeLangs;
                    $shopTypeLangs = ArrayHelper::index($shopTypeLangs, 'lang_id');
                    foreach($languages as $language){
                        $shopTypeLang = isset($shopTypeLangs[$language->id]) ? $shopTypeLangs[$language->id] : new ShopTypeLang();
                        $formModel->translationName[$language->id] = $shopTypeLang->name;
                        $formModel->translationDescription[$language->id] = $shopTypeLang->description;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => ShopType::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => ShopType::className(),
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

        $model->saveLangsRelations('shopTypeLangs', $formModel, 'translationName', 'name', 'shop_type_id');
        $model->saveLangsRelations('shopTypeLangs', $formModel, 'translationDescription', 'description', 'shop_type_id');

        return $model;
    }

    public function actionIndex()
    {
        $searchModel = new ShopTypeSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

} 