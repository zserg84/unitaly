<?php

use modules\directory\Module as DirectoryModule;
use yii\grid\ActionColumn;
use vova07\themes\admin\widgets\Box;
use yii\grid\CheckboxColumn;
use yii\helpers\Url;
use yii\helpers\Html;
use vova07\themes\admin\widgets\GridView;
use yii\helpers\ArrayHelper;
use modules\directory\models\ShopType;

$this->title = DirectoryModule::t('shop', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('shop', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
	$this->title
];

$gridId = 'shop-grid';
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
                ['class'=>'form-control','prompt' => DirectoryModule::t('shop', 'FRONTEND')]
            ),
            'value' => function($data){
                $class = 'glyphicon ';
                $class .= $data->frontend ? 'glyphicon-ok' : 'glyphicon-remove';
                return '<span class="'.$class.'"></span>';
            }
        ],
        [
            'attribute' => 'shopTypeName',
            'filter' => Html::activeDropDownList($searchModel, 'shopTypeName', ArrayHelper::map(ShopType::find()->lang()->all(), 'id', 'name'),['class'=>'form-control','prompt' => DirectoryModule::t('shop', 'SELECT_SHOP_TYPE')]),
        ],
        'name',
        'cityName',
    ]
];

$boxButtons = $actions = [];
$showActions = false;

if (Yii::$app->user->can('BCreateShop')) {
	$boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BUpdateShop')) {
	$actions[] = '{update}';
	$showActions = $showActions || true;
}

//if (Yii::$app->user->can('BViewShopSchedule')) {
$actions[] = '{schedule}';
$showActions = $showActions || true;
$gridButtons['schedule'] = function ($url, $model) {
    return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['shop-schedule/index', 'shopId' => $model->id],
        [
            'class' => 'grid-action',
        ]);
};
//}

if (Yii::$app->user->can('BDeleteShop')) {
    $boxButtons[] = '{batch-delete}';
    $actions[] = '{delete}';
    $gridButtons['update']  = function ($url, $model, $key) {
        $controllerName = \modules\directory\controllers\backend\ShopController::getEditController($model->shop_type_id);
        $actionName = $controllerName.'/update';
        $customurl = Url::toRoute([$actionName,'id'=>$model['id']]);
        $options =[
            'title' => Yii::t('yii', 'Update'),
            'aria-label' => Yii::t('yii', 'Update'),
            'data-pjax' => '0',
        ];
        return \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $customurl, $options);
    };
    $showActions = $showActions || true;
}

if ($showActions === true) {
	$gridConfig['columns'][] = [
		'class' => ActionColumn::className(),
		'template' => implode(' ', $actions),
        'buttons' => $gridButtons,
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


