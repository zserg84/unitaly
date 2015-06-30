<?php

namespace modules\directory\controllers\backend;

use modules\directory\models\ServiceCategory;
use modules\directory\models\form\PlacementOptionsForm;

class PlacementOptionsController extends OptionsController
{
	public $category = ServiceCategory::CATEGORY_HOTEL;
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['access']['rules'] = [
			[
				'allow' => true,
				'actions' => ['index'],
				'roles' => ['BViewPlacementOptions']
			]
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['create'],
			'roles' => ['BCreatePlacementOptions']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['update'],
			'roles' => ['BUpdatePlacementOptions']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['delete', 'batch-delete'],
			'roles' => ['BDeletePlacementOptions']
		];

		return $behaviors;
	}

	public function init(){
		parent::init();
		$this->formModelClass = PlacementOptionsForm::className();
	}


}