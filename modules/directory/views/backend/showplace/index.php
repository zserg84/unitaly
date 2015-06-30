<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 01.06.15
 * Time: 17:22
 */

use modules\directory\Module as DirectoryModule;
use yii\grid\ActionColumn;
use vova07\themes\admin\widgets\Box;
use vova07\themes\admin\widgets\GridView;
use yii\grid\CheckboxColumn;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use modules\directory\models\ShowplaceType;

$this->title = DirectoryModule::t('showplace', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('showplace', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    $this->title
];

$gridId = 'showplace-grid';
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
        [
            'attribute' => 'showplaceTypeName',
            'filter' => Html::activeDropDownList($searchModel, 'showplaceTypeName', ArrayHelper::map(ShowplaceType::find()->lang()->all(), 'id', 'name'),['class'=>'form-control','prompt' => DirectoryModule::t('showplace', 'SELECT_SHOWPLACE_TYPE')]),
        ],
        'cityName',
    ]
];

$boxButtons = $actions = [];
$showActions = false;

if (Yii::$app->user->can('BCreateShowplace')) {
    $boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BUpdateShowplace')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}
if (Yii::$app->user->can('BDeleteShowplaceType')) {
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