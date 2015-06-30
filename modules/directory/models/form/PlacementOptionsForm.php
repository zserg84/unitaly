<?php
/**
 * форма для опций размещения
 */

namespace modules\directory\models\form;

use modules\directory\models\ServiceCategory;

class PlacementOptionsForm extends OptionsForm
{
	public $messageFileName = 'placement-option';
	public $category = ServiceCategory::CATEGORY_HOTEL;

}