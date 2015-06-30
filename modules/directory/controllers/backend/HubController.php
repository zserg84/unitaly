<?php

namespace modules\directory\controllers\backend;

use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\base\widgets\alphabet\AlphabetListView;
use modules\directory\models\form\HubForm;
use modules\directory\models\Hub;
use modules\directory\models\HubLang;
use modules\directory\models\search\HubSearch;
use modules\translations\models\Lang;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\db\ActiveRecord;

class HubController extends Controller
{
	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['access']['rules'] = [
			[
				'allow' => true,
				'actions' => ['index'],
				'roles' => ['BViewHub']
			]
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['create'],
			'roles' => ['BCreateHub']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['update'],
			'roles' => ['BUpdateHub']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['delete', 'batch-delete'],
			'roles' => ['BDeleteHub']
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
	        'index' => [
		        'class' => IndexAction::className(),
		        'modelClass' => HubSearch::className(),
	        ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Hub::className(),
                'formModelClass' => HubForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel){
	                return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
	            'class' => UpdateAction::className(),
	            'modelClass' => Hub::className(),
	            'formModelClass' => HubForm::className(),
	            'redirectUrl' => Url::toRoute('index'),
	            'ajaxValidation' => true,
	            'beforeAction' => function($model, $formModel){
		            $formModel->image = $model->image;

		            $languages = Lang::find()->all();
		            $hubLangs = $model->hubLangs;
		            $hubLangs = ArrayHelper::index($hubLangs, 'lang_id');
		            foreach($languages as $language){
			            $hubLang = isset($hubLangs[$language->id]) ? $hubLangs[$language->id] : new HubLang();
			            $formModel->translationName[$language->id] = $hubLang->name;
			            $formModel->translationDescription[$language->id] = $hubLang->description;
		            }
		            if ($model->city) {
			            $formModel->region_id = $model->city->province->region_id;
			            $formModel->province_id = $model->city->province_id;
		            }
		            return $formModel;
	            },
	            'afterAction' => function($action, $model, $formModel){
		            return $this->afterEdit($action, $model, $formModel);
	            }
            ],
            'delete' => [
	            'class' => DeleteAction::className(),
	            'modelClass' => Hub::className(),
	            'redirectUrl' => Url::toRoute(['index']),
            ],
	        'batch-delete' => [
		        'class' => BatchDeleteAction::className(),
		        'modelClass' => Hub::className(),
	        ],
        ];
    }

	public function afterEdit($action, $model, $formModel){
		$formModel->image = UploadedFile::getInstance($formModel, 'image');
		if ($image = $formModel->getImage('image')) {
			$model->image_id = $image->id;
			$model->save();
		}
		$model->saveLangsRelations('hubLangs', $formModel, 'translationName', 'name', 'hub_id');
		$model->saveLangsRelations('hubLangs', $formModel, 'translationDescription', 'description', 'hub_id');
		$model->trigger(ActiveRecord::EVENT_AFTER_FIND);
		$firstLetter = mb_substr($model->name,0,1,'utf-8');
		$action->redirectUrl = Url::toRoute(['index', 'q'=>$firstLetter]);
		return $model;
	}
} 