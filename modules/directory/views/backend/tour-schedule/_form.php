<?php

/**
 * TourSchedule form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \modules\directory\models\TourSchedule $model Model
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 */

use modules\directory\Module as DirectoryModule;
use yii\helpers\Html;
use modules\base\components\ActiveForm;
use kartik\time\TimePicker;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'options' => [
        'id' => 'tour_schedule_form',
    ]
]); ?>
<div class="row">
    <div class="col-sm-12">
        <?= $form->field($formModel, 'time_from')->widget(TimePicker::className(), [
            'pluginOptions' => [
                'showMeridian' => false,
                'minuteStep' => 1,
                'secondStep' => 5,
            ]
        ]) ?>
    </div>
</div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($formModel, 'time_to')->widget(TimePicker::className(), [
                'pluginOptions' => [
                    'showMeridian' => false,
                    'minuteStep' => 1,
                    'secondStep' => 5,
                ]
            ]) ?>
        </div>
    </div>
<div class="row">
    <div class="col-sm-12">
        <?= $form->field($formModel, 'text')->textarea() ?>
    </div>
</div>
<?= Html::submitButton(
    $model->isNewRecord ? DirectoryModule::t('tour-schedule', 'BACKEND_CREATE_SUBMIT') : DirectoryModule::t(
        'tour-schedule',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php ActiveForm::end(); ?>