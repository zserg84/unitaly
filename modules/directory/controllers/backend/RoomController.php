<?php

namespace modules\directory\controllers\backend;

use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\UpdateAction;
use modules\base\behaviors\LangSaveBehavior;
use modules\base\widgets\alphabet\AlphabetListView;
use modules\directory\models\Room;
use modules\directory\models\form\RoomForm;
use modules\directory\models\RoomLang;
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
use modules\directory\models\search\RoomSearch;


class RoomController extends Controller
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
            'roles' => ['BViewRoom']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['BCreateRoom']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update'],
            'roles' => ['BUpdateRoom']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete'],
            'roles' => ['BDeleteRoom']
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
                'modelClass' => Room::className(),
                'formModelClass' => RoomForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel) {
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Room::className(),
                'formModelClass' => RoomForm::className(),
                'redirectUrl' => Url::toRoute('index'),
                'ajaxValidation' => true,
                'beforeAction' => function($model, $formModel) {
                    $formModel->main_image = $model->mainImage;
                    $formModel->add_image = $model->addImage;

                    $languages = Lang::find()->all();
                    $roomLangs = $model->roomLangs;
                    $roomLangs = ArrayHelper::index($roomLangs, 'lang_id');
                    foreach($languages as $language) {
                        $roomLang = isset($roomLangs[$language->id]) ? $roomLangs[$language->id] : new RoomLang();
                        $formModel->desc_short_translate[$language->id] = $roomLang->desc_short;
                        $formModel->desc_full_translate[$language->id] = $roomLang->desc_full;
                    }
                    return $formModel;
                },
                'afterAction' => function($action, $model, $formModel){
                    return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Room::className(),
                'redirectUrl' => Url::toRoute(['index']),
            ],
        ];
    }

    /**
     * Index
     */
    public function actionIndex()
    {
        $searchModel = new RoomSearch();

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
        $formModel->add_image = UploadedFile::getInstance($formModel, 'add_image');
        if ($image = $formModel->getImage('add_image')) {
            $model->add_image_id = $image->id;
            $model->save();
        }
        $formModel->main_image = UploadedFile::getInstance($formModel, 'main_image');
        if ($image = $formModel->getImage('main_image')) {
            $model->main_image_id = $image->id;
            $model->save();
        }

        $model->saveLangsRelations('roomLangs', $formModel, 'desc_short_translate', 'desc_short', 'room_id');
        $model->saveLangsRelations('roomLangs', $formModel, 'desc_full_translate', 'desc_full', 'room_id');

        return $model;
    }
}