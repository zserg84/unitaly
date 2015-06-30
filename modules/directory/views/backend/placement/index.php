<?php

/**
 * Placement list view.
 *
 * @var \yii\base\View $this View
 * @var \yii\data\ActiveDataProvider $dataProvider Data provider
 */

use vova07\themes\admin\widgets\Box;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use vova07\themes\admin\widgets\GridView;
use modules\directory\Module as DirectoryModule;
use yii\grid\CheckboxColumn;

$this->title = DirectoryModule::t('placement', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('placement', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    $this->title
];

$gridId = 'placement-grid';
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
    ]
];

$boxButtons = $actions = [];
$showActions = false;

if (Yii::$app->user->can('BCreatePlacement')) {
    $boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BUpdatePlacement')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}

$gridButtons = [];

$actions[] = '{options}';
$gridButtons['options'] = function ($url, $model) {
    return Html::a('<span class="glyphicon glyphicon-wrench"></span>', ['placement/service', 'placementId' => $model->id],
        [
            'class' => 'grid-action',
        ]);
};

if (Yii::$app->user->can('BDeletePlacement')) {
    $boxButtons[] = '{batch-delete}';
    $actions[] = '{delete}';
    $showActions = $showActions || true;
}


if ($showActions === true) {
    $gridConfig['columns'][] = [
        'class' => ActionColumn::className(),
        'template' => implode(' ', $actions),
        'buttons'=>$gridButtons,
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