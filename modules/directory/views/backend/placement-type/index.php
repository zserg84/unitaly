<?php

use vova07\themes\admin\widgets\Box;
use vova07\blogs\Module;
use yii\grid\ActionColumn;
use vova07\themes\admin\widgets\GridView;
use modules\directory\Module as DirectoryModule;

$this->title = DirectoryModule::t('placement', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('placement', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    $this->title
];

$gridId = 'placementtypes-grid';
$gridConfig = [
    'id' => $gridId,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'name',
    ]
];

$boxButtons = $actions = [];
$showActions = false;

if (Yii::$app->user->can('BCreatePlacementType')) {
    $boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BUpdatePlacementType')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}
if (Yii::$app->user->can('BDeletePlacementType')) {
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
            ]
        ); ?>
        <?=  GridView::widget($gridConfig);?>
        <?php Box::end(); ?>
    </div>
</div>