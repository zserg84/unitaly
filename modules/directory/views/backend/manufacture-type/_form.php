<?php

/**
 * ManufactureType form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \modules\directory\models\ManufactureType $model Model
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 */

use modules\directory\Module;
use yii\helpers\Html;
use modules\base\components\ActiveForm;
use modules\translations\models\Lang;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'options' => [
        'id' => 'tour_form',
        'enctype' => 'multipart/form-data',
    ]
]); ?>
<?php $box->beginBody(); ?>
    <?if($model->id):?>
        <div class="row">
            <div class="col-sm-6">
                <?=Html::label($formModel->getAttributeLabel('id'))?>
                <span><?= $model->id ?></span>
            </div>
        </div>
    <?endif?>
    <?
    $languages = Lang::find()->all();
    foreach($languages as $language):?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($formModel, 'translationName[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textInput()->label(
                    $formModel->getAttributeLabel('translationName').', '.$language->name
                );?>
            </div>
        </div>
    <?endforeach;?>
    <?foreach($languages as $language):?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($formModel, 'translationDescription[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textarea()->label(
                    $formModel->getAttributeLabel('translationDescription').', '.$language->name
                );?>
            </div>
        </div>
    <?endforeach;?>
<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Module::t('html', 'BACKEND_CREATE_SUBMIT') : Module::t(
        'html',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>