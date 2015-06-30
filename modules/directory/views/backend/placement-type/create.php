<?php

use vova07\themes\admin\widgets\Box;
use modules\directory\Module;
use modules\directory\Module as DirectoryModule;

$this->title = DirectoryModule::t('placement-type', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('placement-type', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
]; ?>
<div class="row">
    <div class="col-sm-12">
        <?php $box = Box::begin(
            [
                'title' => $this->params['subtitle'],
                'renderBody' => false,
                'options' => [
                    'class' => 'box-primary'
                ],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => '{cancel}'
            ]
        );
        echo $this->render(
            '_form',
            [
                'model' => $model,
                'formModel' => $formModel,
                'box' => $box,
            ]
        );
        Box::end(); ?>
    </div>
</div>