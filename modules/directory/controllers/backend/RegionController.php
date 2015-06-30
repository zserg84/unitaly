<?php

namespace modules\directory\controllers\backend;

use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\UpdateAction;
use modules\base\behaviors\LangSaveBehavior;
use modules\base\widgets\alphabet\AlphabetListView;
use modules\directory\models\form\RegionForm;
use modules\directory\models\Region;
use modules\directory\models\RegionLang;
use modules\directory\models\search\RegionSearch;
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

class RegionController extends Controller
{
	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['access']['rules'] = [
			[
				'allow' => true,
				'actions' => ['index'],
				'roles' => ['BViewRegion']
			]
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['create'],
			'roles' => ['BCreateRegion']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['update'],
			'roles' => ['BUpdateRegion']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['delete', 'batch-delete'],
			'roles' => ['BDeleteRegion']
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
                'modelClass' => Region::className(),
                'formModelClass' => RegionForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel){
	                return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
	            'class' => UpdateAction::className(),
	            'modelClass' => Region::className(),
	            'formModelClass' => RegionForm::className(),
	            'redirectUrl' => Url::toRoute('index'),
	            'ajaxValidation' => true,
	            'beforeAction' => function($model, $formModel){
		            $formModel->visit_image = $model->visitImage;
		            $formModel->flag_image = $model->flagImage;
		            $formModel->arms_image = $model->armsImage;

		            $languages = Lang::find()->all();
		            $regionLangs = $model->regionLangs;
		            $regionLangs = ArrayHelper::index($regionLangs, 'lang_id');
		            foreach($languages as $language){
			            $regionLang = isset($regionLangs[$language->id]) ? $regionLangs[$language->id] : new RegionLang();
			            $formModel->translationName[$language->id] = $regionLang->name;
			            $formModel->translationDescription[$language->id] = $regionLang->description;
			            $formModel->translationSpellings[$language->id] = $regionLang->spellings;
		            }
		            return $formModel;
	            },
	            'afterAction' => function($action, $model, $formModel){
		            return $this->afterEdit($action, $model, $formModel);
	            }
            ],
            'delete' => [
	            'class' => DeleteAction::className(),
	            'modelClass' => Region::className(),
	            'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
	            'class' => BatchDeleteAction::className(),
	            'modelClass' => Region::className(),
            ],
        ];
    }

    public function actionIndex(){
	    $searchModel = new RegionSearch();

	    $dataProvider = $searchModel->search(\Yii::$app->request->get());
	    return $this->render('index', [
		    'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
	    ]);
    }

	public function afterEdit($action, $model, $formModel){
		$formModel->visit_image = UploadedFile::getInstance($formModel, 'visit_image');
		if ($image = $formModel->getImage('visit_image')) {
			$model->visit_image_id = $image->id;
			$model->save();
		}
		$formModel->flag_image = UploadedFile::getInstance($formModel, 'flag_image');
		if ($image = $formModel->getImage('flag_image')) {
			$model->flag_image_id = $image->id;
			$model->save();
		}
		$formModel->arms_image = UploadedFile::getInstance($formModel, 'arms_image');
		if ($image = $formModel->getImage('arms_image')){
			$model->arms_image_id = $image->id;
			$model->save();
		}
		$model->saveLangsRelations('regionLangs', $formModel, 'translationName', 'name', 'region_id');
		$model->saveLangsRelations('regionLangs', $formModel, 'translationDescription', 'description', 'region_id');
		$model->saveLangsRelations('regionLangs', $formModel, 'translationSpellings', 'spellings', 'region_id');
		$model->trigger(ActiveRecord::EVENT_AFTER_FIND);
		$firstLetter = mb_substr($model->name,0,1,'utf-8');
		$action->redirectUrl = Url::toRoute(['index', 'q'=>$firstLetter]);
		return $model;
	}
} 