<?php
/**
 * форма для опций туров
 */

namespace modules\directory\models\form;
use modules\directory\Module as DirectoryModule;
use modules\directory\models\ServiceCategory;

class TourOptionsForm extends OptionsForm
{
	public $messageFileName = 'tour-option';
	public $category = ServiceCategory::CATEGORY_TOUR;

	public function attributeLabels()
	{
		return parent::attributeLabels() + [
			'service_type_id' => DirectoryModule::t($this->messageFileName, 'SERVICE_TYPE_ID'),
		];
	}

}