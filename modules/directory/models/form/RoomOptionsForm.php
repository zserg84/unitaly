<?php
/**
 * форма для опций номеров
 */

namespace modules\directory\models\form;

use modules\directory\models\ServiceCategory;

class RoomOptionsForm extends OptionsForm
{
	public $messageFileName = 'room-option';
	public $category = ServiceCategory::CATEGORY_ROOM;

}