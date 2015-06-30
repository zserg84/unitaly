<?php

/**
 * Hub form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var $formModel \modules\directory\models\Hub Model
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 */

use modules\directory\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\base\components\ActiveForm;
use yii\helpers\ArrayHelper;
use modules\directory\models\City;
use dosamigos\fileinput\BootstrapFileInput;
use kartik\depdrop\DepDrop;
use modules\directory\models\Region;
use modules\translations\models\Lang;
use modules\directory\models\Province;

$languages = Lang::find()->all();
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
	'options' => [
		'id' => 'hub_form',
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
			<?=$form->field($formModel, 'region_id')->dropDownList(ArrayHelper::map(Region::find()->all(), 'id', 'name'), [
				'id'=>'hubform-region_id',
				'prompt' => $formModel->getAttributeLabel('region_id'),
			])?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'province_id')->widget(DepDrop::classname(), [
				'data'=> ArrayHelper::map(Province::find()->where(['region_id'=>$formModel->region_id])->all(), 'id', 'name'),
				'options'=>[
					'prompt' => $formModel->getAttributeLabel('province_id'),
				],
				'pluginOptions'=>[
					'depends'=>['hubform-region_id'],
					'placeholder' => $formModel->getAttributeLabel('province_id'),
					'url'=>Url::to(['/base/ajax/get-provinces']),
				],
				'pluginEvents' => [
					"depdrop.afterChange"=>"function(event, id, value) {}",
				],
			]);?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'city_id')->widget(DepDrop::classname(), [
				'data'=> ArrayHelper::map(City::find()->where(['province_id'=>$formModel->province_id])->all(), 'id', 'name'),
				'options'=>[
					'prompt' => $formModel->getAttributeLabel('city_id'),
				],
				'pluginOptions'=>[
					'depends'=>['hubform-region_id', 'hubform-province_id'],
					'placeholder' => $formModel->getAttributeLabel('city_id'),
					'url'=>Url::to(['/base/ajax/get-cities']),
				],
				'pluginEvents' => [
					"depdrop.afterChange"=>"function(event, id, value) {}",
				],
			]);?>
		</div>
	</div>

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
			]);?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'airport')->textInput() ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'port')->textInput() ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'code_iata')->textInput() ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'code_icao')->textInput() ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'arrival_table')->textInput() ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'departure_table')->textInput() ?>
		</div>
	</div>
<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
	$model->isNewRecord ? Module::t('hub', 'BACKEND_CREATE_SUBMIT') : Module::t(
		'hub',
		'BACKEND_UPDATE_SUBMIT'
	),
	[
		'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
	]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>