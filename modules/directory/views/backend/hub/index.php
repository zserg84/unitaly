<?php

use vova07\themes\admin\widgets\Box;
use yii\grid\ActionColumn;
use vova07\themes\admin\widgets\GridView;
use modules\directory\Module as DirectoryModule;
use yii\grid\CheckboxColumn;

$this->title = DirectoryModule::t('hub', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('hub', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
	$this->title
];

$gridId = 'hub-grid';
$gridConfig = [
	'id' => $gridId,
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => [
		[
			'class' => CheckboxColumn::classname()
		],
		'id',
		'name',
		'cityName',
	]
];

$boxButtons = $actions = [];
$showActions = false;

if (Yii::$app->user->can('BCreateHub')) {
	$boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BUpdateHub')) {
	$actions[] = '{update}';
	$showActions = $showActions || true;
}
if (Yii::$app->user->can('BDeleteHub')) {
	$boxButtons[] = '{batch-delete}';
	$actions[] = '{delete}';
	$showActions = $showActions || true;
}


if ($showActions === true) {
	$gridConfig['columns'][] = [
		'class' => ActionColumn::className(),
		'template' => implode(' ', $actions),
	];
}

$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null; ?>

<div class="row">
	<div class="col-xs-12">
		<?php Box::begin(
			[
				'title' => $this->params['subtitle'],
				'bodyOptions' => [
					'class' => 'table-responsive'
				],
				'buttonsTemplate' => $boxButtons,
				'grid' => $gridId,
			]
		); ?>
		<?=  GridView::widget($gridConfig);?>
		<?php Box::end(); ?>
	</div>
</div>