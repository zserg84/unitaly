<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use modules\directory\controllers\console\RbacController;
use modules\translations\controllers\console\I18nController;


/**
 * Console
 */
class MakeController extends Controller
{
	/**
	 * @usage php yii make/all
	 */
	public function actionAll()
	{
		$done = $this->ansiFormat('DONE', Console::BG_GREEN);

		# rbac
//		$name = $this->ansiFormat('RBAC', Console::BG_BLACK);
//		echo "\n\n$name ...";
//		$var = new RbacController('second', Yii::$app->module);
//		$var->actionAdd();
//		echo "$done";

		# modules/themes/messages
		$name = $this->ansiFormat('modules/themes/messages', Console::BG_BLACK);
		echo "\n$name ...";
		$var = new I18nController('i18n', Yii::$app->module);
		$var->actionImport('modules/themes/messages', false);
		echo "$done";

		# modules/directory/messages
		$name = $this->ansiFormat('modules/directory/messages', Console::BG_BLACK);
		echo "\n$name ...";
		$var = new I18nController('i18n', Yii::$app->module);
		$var->actionImport('modules/directory/messages', false);
		echo "$done";

		echo "\n";

		return 0;
	}
}