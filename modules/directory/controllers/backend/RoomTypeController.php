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
use modules\directory\models\form\RoomTypeForm;
use modules\directory\models\search\RoomTypeSearch;
use modules\directory\models\RoomType;
use modules\directory\models\RoomTypeLang;
use modules\translations\models\Lang;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

class RoomTypeController extends Controller
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
                'roles' => ['BViewRoomType']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateRoomType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update'],
            'roles' => ['BUpdateRoomType']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'batch-delete'],
            'roles' => ['BDeleteRoomType']
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
                'modelClass' => RoomType::className(),
                'formModelClass' => RoomTypeForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => RoomType::className(),
                'formModelClass' => RoomTypeForm::className(),
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel){
                    $formModel->image = $model->image;

                    $languages = Lang::find()->all();
                    $roomTypeLangs = $model->roomTypeLangs;
                    $roomTypeLangs = ArrayHelper::index($roomTypeLangs, 'lang_id');
                    foreach($languages as $language){
                        $roomTypeLang = isset($roomTypeLangs[$language->id]) ? $roomTypeLangs[$language->id] : new RoomTypeLang();
                        $formModel->translationName[$language->id] = $roomTypeLang->name;
                        $formModel->translationDescription[$language->id] = $roomTypeLang->description;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => RoomType::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
                'class' => BatchDeleteAction::className(),
                'modelClass' => RoomType::className(),
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

        $model->saveLangsRelations('roomTypeLangs', $formModel, 'translationName', 'name', 'room_type_id');
        $model->saveLangsRelations('roomTypeLangs', $formModel, 'translationDescription', 'description', 'room_type_id');

        return $model;
    }

    public function actionIndex()
    {
        $searchModel = new RoomTypeSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

} 