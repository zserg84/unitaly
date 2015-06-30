<?php

namespace modules\directory\controllers\backend;

use common\actions\BatchDeleteAction;
use common\actions\CreateAction;
use common\actions\DeleteAction;
use common\actions\UpdateAction;
use modules\directory\models\AdditionalService;
use modules\directory\models\form\OptionsForm;
use modules\directory\models\search\AdditionalServiceSearch;
use modules\translations\models\Lang;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
use modules\directory\models\ServiceCategory;
use modules\directory\models\ServiceType;

class OptionsController extends Controller
{
	public $category;
	public $formModelClass;

	public function behaviors( ){
		$behaviors = parent::behaviors();

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

    public function actionIndex(){
	    /**
	     * @var  $query \yii\db\ActiveQuery
	     */
		$searchModel = new AdditionalServiceSearch();
	    $searchModel->category = $this->category;
	    $dataProvider = $searchModel->search(\Yii::$app->request->get());
	    return $this->render('index', [
		    'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
	    ]);
    }

	public function actions()
	{
		return [
			'create' => [
				'class' => CreateAction::className(),
				'modelClass' => AdditionalService::className(),
				'formModelClass' => $this->formModelClass,
				'ajaxValidation' => true,
				'redirectUrl' => Url::toRoute('index'),
				'afterAction' => function($action, $model, $formModel){
					return $this->afterEdit($action, $model, $formModel);
				},
				'beforeAction' => function($model, $formModel){
					$serviceType = ServiceType::find()->andWhere(['=', 'category_id', $this->category])->one();
					if (!$serviceType) {
						$category = ServiceCategory::findOne($this->category);
						$serviceType = new ServiceType();
						$serviceType->setOneByCategory($category)->save();
					}
					$formModel->service_type_id = $serviceType->id;

					return $formModel;
				},
			],
			'update' => [
				'class' => UpdateAction::className(),
				'modelClass' => AdditionalService::className(),
				'formModelClass' => $this->formModelClass,
				'redirectUrl' => Url::toRoute('index'),
				'ajaxValidation' => true,
				'beforeAction' => function($model, $formModel){
					return $this->beforeEdit($model, $formModel);
				},
				'afterAction' => function($action, $model, $formModel){
					return $this->afterEdit($action, $model, $formModel);
				}
			],
			'delete' => [
				'class' => DeleteAction::className(),
				'modelClass' => AdditionalService::className(),
				'redirectUrl' => Url::toRoute(['index']),
			],
			'batch-delete' => [
				'class' => BatchDeleteAction::className(),
				'modelClass' => AdditionalService::className(),
			],
		];
	}

	public function afterEdit($action, $model, $formModel){
		$formModel->image = UploadedFile::getInstance($formModel, 'image');
		if ($image = $formModel->getImage('image')) {
			$model->image_id = $image->id;
			$model->save();
		}
		$model->saveLangsRelations('additionalServiceLangs', $formModel, 'translationName', 'name', 'additional_service_id');
		$model->saveLangsRelations('additionalServiceLangs', $formModel, 'translationDescription', 'description', 'additional_service_id');
		$model->trigger(ActiveRecord::EVENT_AFTER_FIND);
		$firstLetter = mb_substr($model->name,0,1,'utf-8');
		$action->redirectUrl = Url::toRoute(['index', 'q'=>$firstLetter]);
		return $model;
	}

	public function beforeEdit($model, $formModel){
		$formModel->image = $model->image;

		$languages = Lang::find()->all();
		$langs = $model->additionalServiceLangs;
		$langs = ArrayHelper::index($langs, 'lang_id');
		foreach($languages as $language){
			$lang = isset($langs[$language->id]) ? $langs[$language->id] : new $this->langModelClass;
			$formModel->translationName[$language->id] = $lang->name;
			$formModel->translationDescription[$language->id] = $lang->description;
		}
		return $formModel;
	}
}