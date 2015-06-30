<?php

/**
 * Showplace create view.
 *
 * @var \yii\base\View $this View
 * @var \modules\directory\models\Showplace $model Model
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 */

use vova07\themes\admin\widgets\Box;
use modules\directory\Module;

$this->title = Module::t('showplace', 'BACKEND_CREATE_TITLE');
$this->params['subtitle'] = Module::t('showplace', 'BACKEND_CREATE_SUBTITLE');
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
//                'langArr' => $langArr,
            ]
        );
        Box::end(); ?>
    </div>
</div>