<?php

/**
 * ShopSchedule form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \modules\directory\models\ShopSchedule $model Model
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 */

use modules\directory\Module as DirectoryModule;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'options' => [
        'id' => 'shop_schedule_form',
    ]
]); ?>
<div class="row">
    <div class="col-sm-12">
        <?= $form->field($formModel, 'date_from')->widget(DatePicker::className(), [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pluginOptions' => [
                'format' => 'dd.mm.yyyy',
            ],
        ]) ?>
    </div>
</div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($formModel, 'date_to')->widget(DatePicker::className(), [
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                ],
            ]) ?>
        </div>
    </div>
<div class="row">
    <div class="col-sm-12">
        <?= $form->field($formModel, 'text')->textarea() ?>
    </div>
</div>
<?= Html::submitButton(
    $model->isNewRecord ? DirectoryModule::t('shop-schedule', 'BACKEND_CREATE_SUBMIT') : DirectoryModule::t(
        'shop-schedule',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php ActiveForm::end(); ?>