<?php

namespace modules\directory\controllers\backend;

use modules\directory\models\ServiceCategory;
use modules\directory\models\form\RoomOptionsForm;

class RoomOptionsController extends OptionsController
{
	public $category = ServiceCategory::CATEGORY_ROOM;
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['access']['rules'] = [
			[
				'allow' => true,
				'actions' => ['index'],
				'roles' => ['BViewRoomOptions']
			]
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['create'],
			'roles' => ['BCreateRoomOptions']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['update'],
			'roles' => ['BUpdateRoomOptions']
		];
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['delete', 'batch-delete'],
			'roles' => ['BDeleteRoomOptions']
		];

		return $behaviors;
	}

	public function init(){
		parent::init();
		$this->formModelClass = RoomOptionsForm::className();
	}


}