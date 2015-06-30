<?php

use yii\bootstrap\Tabs;
use modules\directory\Module as DirectoryModule;

?>
<?php
echo Tabs::widget([
    'items' => [
        [
            'label' => DirectoryModule::t('placement', 'TABS_CHAR'),
            'active' => true,
            'content' => $this->render('_main', [
                'formModel' => $formModel,
                'box' => $box,
                'model' => $model
            ])
        ],
        [
            'label' => DirectoryModule::t('restaurant', 'TABS_KITCHEN_TYPE'),
            'content' => $this->render('_kitchen', [
                'formModel' => $formModel,
                'box' => $box,
                'model' => $model
            ])
        ],
    ],
]);
