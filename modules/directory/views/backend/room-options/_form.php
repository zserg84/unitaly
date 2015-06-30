<?php

/**
 * Region form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var $formModel \modules\directory\models\form\RegionForm Model
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 */

use modules\directory\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use modules\directory\models\City;
use dosamigos\fileinput\BootstrapFileInput;
use modules\translations\models\Lang;

$languages = Lang::find()->all();
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
	'options' => [
		'id' => 'region_form',
		'enctype' => 'multipart/form-data',
	]
]); ?>
<?php $box->beginBody(); ?>
<?php if (!$model->getIsNewRecord()) : ?>
	<div class="row">
		<div class="col-sm-6">
			<?=Html::label($formModel->getAttributeLabel('id'))?>
			<span><?= $model->id ?></span>
		</div>
	</div>
<?php endif; ?>
<?
echo $form->field($formModel, 'service_type_id')->hiddenInput()->label(false);
foreach($languages as $language):?>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'translationName[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textInput()->label(
				$formModel->getAttributeLabel('translationName').', '.$language->name
			);?>
		</div>
	</div>
<?endforeach;?>
<?php
foreach($languages as $language):?>
	<div class="row">
		<div class="col-sm-12">
			<?= $form->field($formModel, 'translationDescription[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textarea()->label(
				$formModel->getAttributeLabel('translationDescription').', '.$language->name
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
				$initialPreview[] = '<img src="'.$formModel->image->getSrc().'" alt="" width="100px" height="100px">';
				$previewConfig[] = [
//                'width' => '100px',
//                'height' => '100px',
//                'url' => Url::toRoute(['image-delete']),
//                'key' => $formModel->image->id,
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
			])->error(false);?>
		</div>
	</div>
<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
	$model->isNewRecord ? Module::t($formModel->messageFileName, 'BACKEND_CREATE_SUBMIT') : Module::t(
		$formModel->messageFileName,
		'BACKEND_UPDATE_SUBMIT'
	),
	[
		'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
	]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>