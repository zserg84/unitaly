<?php

/**
 * Manufacture list view.
 *
 * @var \yii\base\View $this View
 * @var \yii\data\ActiveDataProvider $dataProvider Data provider
 */

use vova07\themes\admin\widgets\Box;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\ActionColumn;
use vova07\themes\admin\widgets\GridView;
use modules\directory\Module as DirectoryModule;
use yii\grid\CheckboxColumn;
use modules\directory\models\ManufactureType;

$this->title = DirectoryModule::t('manufacture', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('manufacture', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    $this->title
];

$gridId = 'manufacture-grid';
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
                ['class'=>'form-control','prompt' => DirectoryModule::t('manufacture', 'FRONTEND')]
            ),
            'value' => function($data){
                $class = 'glyphicon ';
                $class .= $data->frontend ? 'glyphicon-ok' : 'glyphicon-remove';
                return '<span class="'.$class.'"></span>';
            }
        ],
        [
            'attribute' => 'manufactureTypeName',
            'filter' => Html::activeDropDownList($searchModel, 'manufactureTypeName', ArrayHelper::map(ManufactureType::find()->lang()->all(), 'id', 'name'),['class'=>'form-control','prompt' => DirectoryModule::t('manufacture', 'SELECT_MANUFACTURE_TYPE')]),
        ],
        'name',
    ]
];

$boxButtons = $actions = [];
$showActions = false;

if (Yii::$app->user->can('BCreateManufacture')) {
    $boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BUpdateManufacture')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}

$gridButtons = [];

if (Yii::$app->user->can('BDeleteManufacture')) {
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