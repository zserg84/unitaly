<?php

use modules\directory\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\base\components\ActiveForm;
use dosamigos\fileinput\BootstrapFileInput;
use modules\translations\models\Lang;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'options' => [
        'id' => 'shop_category_form',
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
    <div class="row">
        <div class="col-sm-6">
            <?
            $initialPreview = [];
            $previewConfig = [];
            if($formModel->image){
                $initialPreview[] = '<img src="'.$formModel->image->getSrc().'" alt="" class="file-preview-image">';
                $previewConfig[] = [
                    'url' => Url::toRoute(['image-delete']),
                    'key' => $formModel->image->id,
                ];
            }
            ?>
            <?= $form->field($formModel, 'image')->widget(BootstrapFileInput::className(), [
                'options' => ['accept' => 'image/*'],
                'clientOptions' => [
                    'browseClass' => 'btn btn-success',
                    'uploadClass' => 'btn btn-info',
                    'removeClass' => 'btn btn-danger',
                    'removeIcon' => '<i class="glyphicon glyphicon-trash"></i> ',
                    'showUpload' => false,
                    'initialPreview' => $initialPreview,
                    'initialPreviewConfig' => $previewConfig,
                    'initialPreviewShowDelete' => false,
                ]
            ]);?>
        </div>
    </div>
    <?
    foreach($languages as $language):?>
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
    $model->isNewRecord ? Module::t('market-category', 'BACKEND_CREATE_SUBMIT') : Module::t(
        'market-category',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>