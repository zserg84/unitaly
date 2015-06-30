<?php

use modules\directory\Module as DirectoryModule;
use yii\grid\ActionColumn;
use vova07\themes\admin\widgets\Box;
use modules\base\widgets\alphabet\AlphabetListView;
use yii\grid\CheckboxColumn;
use vova07\themes\admin\widgets\GridView;

$this->title = DirectoryModule::t('province', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('province', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
	$this->title
];

$gridId = 'province-grid';
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
        'regionName',
    ]
];

$boxButtons = $actions = [];
$showActions = false;

if (Yii::$app->user->can('BCreateProvince')) {
	$boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BUpdateProvince')) {
	$actions[] = '{update}';
	$showActions = $showActions || true;
}
if (Yii::$app->user->can('BDeleteProvince')) {
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


