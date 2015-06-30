<?php

/**
 * ShopSchedule update view.
 *
 * @var yii\base\View $this View
 * @var modules\directory\models\ShopSchedule $model Model
 */

use modules\directory\Module as DirectoryModule;
use yii\bootstrap\Modal;

Modal::begin([
    'id' => 'schedule-modal',
    'header' => '<h2>'.DirectoryModule::t('shop-schedule', 'MODAL_TITLE_UPDATE').'</h2>',
]);
echo $this->render(
    '_form',
    [
        'model' => $model,
        'formModel' => $formModel,
    ]
);
Modal::end();
$this->registerJS('
     $("#schedule-modal").modal("show");
', \yii\web\View::POS_END);