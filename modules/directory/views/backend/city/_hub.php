<?php
/**
 * @var $hub modules\directory\models\Hub
 */
use modules\directory\models\form\HubForm;
$hubForm = new HubForm();
$hubForm->setAttributes($hub);
echo '<ol>';
foreach (['identifier', 'code_iata', 'code_icao', 'arrival_table', 'departure_table'] as $v) {
	echo '<li>' . $hubForm->getAttributeLabel($v) . ': ' . $hub->$v;
}
echo '</ol>';
