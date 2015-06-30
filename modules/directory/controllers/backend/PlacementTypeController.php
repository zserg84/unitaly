<?php

namespace modules\directory\controllers\backend;

use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\UpdateAction;
use modules\base\behaviors\LangSaveBehavior;
use modules\base\widgets\alphabet\AlphabetListView;
use modules\directory\models\PlacementType;
use modules\directory\models\form\PlacementTypeForm;
use modules\directory\models\PlacementTypeLang;
use modules\directory\Module;
use modules\image\models\Image;
use modules\translations\models\Lang;
use vova07\users\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use modules\directory\models\search\PlacementTypeSearch;


class PlacementTypeController extends Controller
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
            'roles' => ['BViewPlacementType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreatePlacementType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update', 'image-delete'],
            'roles' => ['BUpdatePlacementType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete'],
            'roles' => ['BDeletePlacementType']
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
                'modelClass' => PlacementType::className(),
                'formModelClass' => PlacementTypeForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel) {
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => PlacementType::className(),
                'formModelClass' => PlacementTypeForm::className(),
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel) {
                    $formModel->image = $model->image;

                    $languages = Lang::find()->all();
                    $placementLangs = $model->placementTypeLangs;
                    $placementLangs = ArrayHelper::index($placementLangs, 'lang_id');
                    foreach($languages as $language) {
                        $placementLang = isset($placementLangs[$language->id]) ? $placementLangs[$language->id] : new PlacementTypeLang();
                        $formModel->translationName[$language->id] = $placementLang->name;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => PlacementType::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
            'image-delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Image::className(),
                'modelIdName' => 'key',
                'redirectUrl' => false,
            ],
        ];
    }

    /**
     * Index
     */
    public function actionIndex()
    {
        $searchModel = new PlacementTypeSearch();

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
        $formModel->image = UploadedFile::getInstance($formModel, 'image');
        if ($image = $formModel->getImage('image')) {
            $model->image_id = $image->id;
            $model->save();
        }

        $model->saveLangsRelations('placementTypeLangs', $formModel, 'translationName', 'name', 'placement_type_id');

        return $model;
    }
}