<?php

use vova07\themes\admin\widgets\Box;
use yii\grid\ActionColumn;
use vova07\themes\admin\widgets\GridView;
use modules\directory\Module as DirectoryModule;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;

$this->title = DirectoryModule::t('region', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('region', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
	$this->title
];

$gridId = 'region-grid';
$gridConfig = [
	'id' => $gridId,
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => [
		[
			'class' => CheckboxColumn::classname()
		],
		'arms_image_id' => [
			'format' => 'html',
			'value' => function($data) {
				return ($data->armsImage) ? Html::img($data->armsImage->getSrc(), ['width' => '100px']) : null;
			},
			'header' => DirectoryModule::t('region', 'ARMS_IMAGE'),
		],
		'id',
		'name',
		'spellings',
	]
];

$boxButtons = $actions = [];
$showActions = false;

if (Yii::$app->user->can('BCreateRegion')) {
	$boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BUpdateRegion')) {
	$actions[] = '{update}';
	$showActions = $showActions || true;
}
if (Yii::$app->user->can('BDeleteRegion')) {
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