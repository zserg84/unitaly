<?php

/**
 * Placement type update view.
 *
 * @var yii\base\View $this View
 * @var modules\directory\models\Showplace $model Model
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 * @var array $statusArray Statuses array
 */

use vova07\themes\admin\widgets\Box;
use modules\directory\Module;
use modules\directory\Module as DirectoryModule;

$this->title = DirectoryModule::t('room', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = DirectoryModule::t('room', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
];
$boxButtons = ['{cancel}'];

$boxButtons[] = '{create}';

$boxButtons[] = '{delete}';

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
                'buttonsTemplate' => $boxButtons
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