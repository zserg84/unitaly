<?php

namespace modules\directory\controllers\backend;

use modules\directory\models\ServiceCategory;
use modules\directory\models\form\TourOptionsForm;

class TourOptionsController extends OptionsController
{
	public $category = ServiceCategory::CATEGORY_TOUR;
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['access']['rules'] = [
			[
				'allow' => true,
				'actions' => ['index'],
				'roles' => ['BViewTourOptions']
			]
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['create'],
			'roles' => ['BCreateTourOptions']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['update'],
			'roles' => ['BUpdateTourOptions']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['delete', 'batch-delete'],
			'roles' => ['BDeleteTourOptions']
		];

		return $behaviors;
	}

	public function actions()
	{
		$actions = parent::actions();
		unset($actions['create']['beforeAction']);
		return $actions;
	}

	public function init(){
		parent::init();
		$this->formModelClass = TourOptionsForm::className();
	}


}