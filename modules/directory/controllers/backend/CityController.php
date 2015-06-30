<?php

namespace modules\directory\controllers\backend;

use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\IndexAction;
use common\actions\UpdateAction;
use modules\base\widgets\alphabet\AlphabetListView;
use modules\directory\models\form\CityForm;
use modules\directory\models\City;
use modules\directory\models\CityLang;
use modules\directory\models\Hub;
use modules\directory\models\Province;
use modules\directory\models\search\CitySearch;
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
use modules\directory\models\Showplace;
use yii\db\ActiveRecord;

class CityController extends Controller
{
	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['access']['rules'] = [
			[
				'allow' => true,
				'actions' => ['index'],
				'roles' => ['BViewCity']
			]
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['create'],
			'roles' => ['BCreateCity']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['update'],
			'roles' => ['BUpdateCity']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['delete', 'batch-delete'],
			'roles' => ['BDeleteCity']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['hubinfo'],
			'roles' => ['BViewCity']
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
		        'modelClass' => CitySearch::className(),
	        ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => City::className(),
                'formModelClass' => CityForm::className(),
                'ajaxValidation' => true,
                'redirectUrl' => Url::toRoute('index'),
                'afterAction' => function($action, $model, $formModel){
	                return $this->afterEdit($action, $model, $formModel);
                }
            ],
            'update' => [
	            'class' => UpdateAction::className(),
	            'modelClass' => City::className(),
	            'formModelClass' => CityForm::className(),
	            'redirectUrl' => Url::toRoute('index'),
	            'ajaxValidation' => true,
	            'beforeAction' => function($model, $formModel){
		            $formModel->visit_image = $model->visitImage;
		            $formModel->arms_image = $model->armsImage;
		            $province = Province::findOne($formModel->province_id);
		            if($province){
			            $formModel->region_id = $province->region_id;
		            }
		            $languages = Lang::find()->all();
		            $cityLangs = $model->cityLangs;
		            $cityLangs = ArrayHelper::index($cityLangs, 'lang_id');
		            foreach($languages as $language){
			            $cityLang = isset($cityLangs[$language->id]) ? $cityLangs[$language->id] : new CityLang();
			            $formModel->translationName[$language->id] = $cityLang->name;
			            $formModel->translationDescription[$language->id] = $cityLang->description;
			            $formModel->translationHistory[$language->id] = $cityLang->history;
			            $formModel->translationSpellings[$language->id] = $cityLang->spellings;
		            }
		            return $formModel;
	            },
	            'afterAction' => function($action, $model, $formModel){
		            return $this->afterEdit($action, $model, $formModel);
	            }
            ],
            'delete' => [
	            'class' => DeleteAction::className(),
	            'modelClass' => City::className(),
	            'redirectUrl' => Url::toRoute(['index']),
            ],
            'batch-delete' => [
	            'class' => BatchDeleteAction::className(),
	            'modelClass' => City::className(),
            ],
        ];
    }

	public function actionHubinfo($hub_id = null){
		if ($hub = Hub::findOne($hub_id)) {
			echo $this->renderAjax('_hub', ['hub' => $hub]);
		} else {

		}
	}

	public function afterEdit($action, $model, $formModel){
		$formModel->visit_image = UploadedFile::getInstance($formModel, 'visit_image');
		if ($image = $formModel->getImage('visit_image')) {
			$model->visit_image_id = $image->id;
			$model->save();
		}
		$formModel->arms_image = UploadedFile::getInstance($formModel, 'arms_image');
		if ($image = $formModel->getImage('arms_image')){
			$model->arms_image_id = $image->id;
			$model->save();
		}
		$model->saveLangsRelations('cityLangs', $formModel, 'translationName', 'name', 'city_id');
		$model->saveLangsRelations('cityLangs', $formModel, 'translationDescription', 'description', 'city_id');
		$model->saveLangsRelations('cityLangs', $formModel, 'translationHistory', 'history', 'city_id');
		$model->saveLangsRelations('cityLangs', $formModel, 'translationSpellings', 'spellings', 'city_id');
		Showplace::setToMain($model->id, $formModel->main_showplaces);
		$model->trigger(ActiveRecord::EVENT_AFTER_FIND);
		return $model;
	}
}