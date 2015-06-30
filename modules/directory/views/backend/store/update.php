<?php

use vova07\themes\admin\widgets\Box;
use modules\directory\Module;

$this->title = Module::t('shop', 'BACKEND_STORE_UPDATE_TITLE');
$this->params['subtitle'] = Module::t('shop', 'BACKEND_STORE_UPDATE_SUBTITLE');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
];
$boxButtons[] = '{create}';

$boxButtons[] = '{delete}';

$boxButtons[] = '{cancel}';
$buttons['cancel'] = [
    'url' => ['shop/index'],
    'icon' => 'fa-reply',
    'options' => [
        'class' => 'btn-default',
        'title' => Yii::t('vova07/themes/admin/widgets/box', 'Cancel')
    ]
];

$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null; ?>
<div class="row">
    <div class="col-sm-12">
        <?php $box = Box::begin(
            [
                'title' => $this->params['subtitle'],
                'renderBody' => false,
                'options' => [
                    'class' => 'box-success'
                ],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => $boxButtons,
                'buttons' => $buttons,
            ]
        );
        echo $this->render(
            '_form',
            [
                'model' => $model,
                'formModel' => $formModel,
                'box' => $box
            ]
        );
        Box::end(); ?>
    </div>
</div>