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
use modules\directory\models\form\ShowplaceTypeForm;
use modules\directory\models\search\ShowplaceTypeSearch;
use modules\directory\models\ShowplaceType;
use modules\directory\models\ShowplaceTypeLang;
use modules\image\models\Image;
use modules\translations\models\Lang;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

class ShowplaceTypeController extends Controller
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
                'roles' => ['BViewShowplaceType']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateShowplaceType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update', 'image-delete'],
            'roles' => ['BUpdateShowplaceType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteShowplaceType']
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
                'modelClass' => ShowplaceType::className(),
                'formModelClass' => ShowplaceTypeForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => ShowplaceType::className(),
                'formModelClass' => ShowplaceTypeForm::className(),
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel){
                    $formModel->image = $model->image;

                    $languages = Lang::find()->all();
                    $showplaceTypeLangs = $model->showplaceTypeLangs;
                    $showplaceTypeLangs = ArrayHelper::index($showplaceTypeLangs, 'lang_id');
                    foreach($languages as $language){
                        $showplaceTypeLang = isset($showplaceTypeLangs[$language->id]) ? $showplaceTypeLangs[$language->id] : new ShowplaceTypeLang();
                        $formModel->translationName[$language->id] = $showplaceTypeLang->name;
                        $formModel->translationDescription[$language->id] = $showplaceTypeLang->description;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => ShowplaceType::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => ShowplaceType::className(),
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

    public function afterEdit($action, $model, $formModel){
        $formModel->image = UploadedFile::getInstance($formModel, 'image');
        $image = $formModel->getImage('image');
        if($image){
            $model->image_id = $image->id;
            $model->save();
        }

        $model->saveLangsRelations('showplaceTypeLangs', $formModel, 'translationName', 'name', 'showplace_type_id');
        $model->saveLangsRelations('showplaceTypeLangs', $formModel, 'translationDescription', 'description', 'showplace_type_id');

        return $model;
    }

    public function actionIndex()
    {
        $searchModel = new ShowplaceTypeSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

} 