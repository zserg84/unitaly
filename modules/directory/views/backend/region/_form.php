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
use modules\base\components\ActiveForm;
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
<?
foreach($languages as $language):?>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'translationName[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textInput()->label(
				$formModel->getAttributeLabel('translationName').', '.$language->name
			);?>
		</div>
	</div>
<?endforeach;?>
<?
foreach($languages as $language):?>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'translationSpellings[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textArea()->label(
				$formModel->getAttributeLabel('translationSpellings').', '.$language->name
			);?>
		</div>
	</div>
<?endforeach;?>
	<div class="row">
		<div class="col-sm-6">
			<?
			$initialPreview = [];
			$previewConfig = [];
			if($formModel->visit_image){
				$initialPreview[] = '<img src="'.$formModel->visit_image->getSrc().'" alt="" width="100px" height="100px">';
				$previewConfig[] = [
//                'width' => '100px',
//                'height' => '100px',
//                'url' => Url::toRoute(['image-delete']),
//                'key' => $formModel->image->id,
				];
			}
			?>
			<?= $form->field($formModel, 'visit_image')->widget(BootstrapFileInput::className(), [
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
	<div class="row">
		<div class="col-sm-6">
			<?
			$initialPreview = [];
			$previewConfig = [];
			if($formModel->flag_image){
				$initialPreview[] = '<img src="'.$formModel->flag_image->getSrc().'" alt="" width="100px" height="100px">';
				$previewConfig[] = [
//                'width' => '100px',
//                'height' => '100px',
//                'url' => Url::toRoute(['image-delete']),
//                'key' => $formModel->image->id,
				];
			}
			?>
			<?= $form->field($formModel, 'flag_image')->widget(BootstrapFileInput::className(), [
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
	<div class="row">
		<div class="col-sm-6">
			<?
			$initialPreview = [];
			$previewConfig = [];
			if($formModel->arms_image){
				$initialPreview[] = '<img src="'.$formModel->arms_image->getSrc().'" alt="" width="100px" height="100px">';
				$previewConfig[] = [
//                'width' => '100px',
//                'height' => '100px',
//                'url' => Url::toRoute(['image-delete']),
//                'key' => $formModel->image->id,
				];
			}
			?>
			<?= $form->field($formModel, 'arms_image')->widget(BootstrapFileInput::className(), [
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
<?php if (!$model->getIsNewRecord()) : ?>
	<div class="row">
		<div class="col-sm-12">
            <?
            $regionId = $model->id;
            $cities = City::find()->innerJoinWith([
                'provinces' => function($query) use($regionId){
                    $query->where([
                        'province.region_id' => $regionId
                    ]);
                }
            ])->all();
            ?>
			<?=$form->field($formModel, 'city_id')->dropDownList(ArrayHelper::map($cities, 'id', 'name'), [
				'id'=>'region-city',
			])->error(false)?>
		</div>
	</div>
<?php endif; ?>
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

<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
	$model->isNewRecord ? Module::t('region', 'BACKEND_CREATE_SUBMIT') : Module::t(
		'region',
		'BACKEND_UPDATE_SUBMIT'
	),
	[
		'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
	]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>