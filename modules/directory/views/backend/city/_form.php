<?php

/**
 * City form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var $formModel \modules\directory\models\CityModel Model
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 */

use modules\directory\Module;
use vova07\imperavi\Widget as Imperavi;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\base\components\ActiveForm;
use yii\helpers\ArrayHelper;
use modules\directory\models\City;
use kartik\switchinput\SwitchInput;
use dosamigos\fileinput\BootstrapFileInput;
use kartik\depdrop\DepDrop;
use modules\directory\models\Region;
use modules\directory\models\Province;
use modules\directory\models\Hub;
use modules\translations\models\Lang;
use modules\directory\models\Showplace;
use nex\chosen\Chosen;

$languages = Lang::find()->all();
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
	'options' => [
		'id' => 'showplace_form',
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
			<?=$form->field($formModel, 'region_id')->dropDownList(ArrayHelper::map(Region::find()->all(), 'id', 'name'), [
				'id'=>'cityform-region_id',
				'prompt' => $formModel->getAttributeLabel('region_id'),
			])?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'province_id')->widget(DepDrop::classname(), [
				'id'=>'cityform-province_id',
				'data'=> ArrayHelper::map(Province::find()->where(['region_id'=>$formModel->region_id])->all(), 'id', 'name'),
				'options'=>[
					'prompt' => $formModel->getAttributeLabel('province_id'),
				],
				'pluginOptions'=>[
					'depends'=>['cityform-region_id'],
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
			<?php
			$showplaces = Showplace::find()->city($model->id)->with('showplaceType')->all();
			$formModel->main_showplaces = Showplace::find()->city($model->id)->main(true)->all();
			echo $form->field($formModel, 'main_showplaces')->widget(
				Chosen::className(), [
				'items' => ArrayHelper::map($showplaces, 'id', 'name', 'showplaceType.name'),
				'multiple' => true,
			]);?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'latitude')->textInput() ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($formModel, 'longitude')->textInput() ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?=$form->field($formModel, 'hub_id')->dropDownList(ArrayHelper::map(Hub::find()->all(), 'id', 'name'), [
				'prompt'=>'',
				'onchange' => '$("#hubInfo").load("' . Url::toRoute('hubinfo') . '?hub_id="+$(this).val());'
			])->error(false)?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6" id="hubInfo">
			<?php if ($model->hub_id) echo $this->render('_hub', ['hub' => $model->hub]); ?>
		</div>
	</div>

<?php
foreach($languages as $language):?>
	<div class="row">
		<div class="col-sm-12">
			<?= $form->field($formModel, 'translationHistory[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textarea()->label(
				$formModel->getAttributeLabel('translationHistory').', '.$language->name
			);?>
		</div>
	</div>
<?endforeach;?>

<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
	$model->isNewRecord ? Module::t('city', 'BACKEND_CREATE_SUBMIT') : Module::t(
		'city',
		'BACKEND_UPDATE_SUBMIT'
	),
	[
		'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
	]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>