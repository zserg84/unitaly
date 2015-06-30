<?php

/**
 * Cafe list view.
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

$this->title = DirectoryModule::t('cafe', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('cafe', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    $this->title
];

$gridId = 'cafe-grid';
$gridConfig = [
    'id' => $gridId,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => CheckboxColumn::classname()
        ],
        'id',
        [
            'attribute' => 'frontend',
            'format' => 'raw',
            'filter' => Html::activeDropDownList($searchModel, 'frontend',
                [Yii::$app->getFormatter()->asBoolean(0), Yii::$app->getFormatter()->asBoolean(1)],
                ['class'=>'form-control','prompt' => DirectoryModule::t('cafe', 'FRONTEND')]
            ),
            'value' => function($data){
                $class = 'glyphicon ';
                $class .= $data->frontend ? 'glyphicon-ok' : 'glyphicon-remove';
                return '<span class="'.$class.'"></span>';
            }
        ],
        'name',
        'cityName',
    ]
];

$boxButtons = $actions = [];
$showActions = false;

if (Yii::$app->user->can('BCreateCafe')) {
    $boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BUpdateCafe')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}

$gridButtons = [];

if (Yii::$app->user->can('BServiceCafe')) {
    $actions[] = '{options}';
    $gridButtons['options'] = function ($url, $model) {
        return Html::a('<span class="glyphicon glyphicon-wrench"></span>', ['cafe/service', 'cafeId' => $model->id],
            [
                'class' => 'grid-action',
            ]);
    };
}

if (Yii::$app->user->can('BDeleteCafe')) {
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