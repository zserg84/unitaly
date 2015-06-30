<?php

use modules\themes\Module as ThemeModule;
use modules\directory\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\base\components\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\switchinput\SwitchInput;
use dosamigos\fileinput\BootstrapFileInput;
use kartik\depdrop\DepDrop;
use modules\directory\models\Placement;
use modules\directory\models\Region;
use modules\directory\models\Province;
use modules\directory\models\City;
use modules\translations\models\Lang;
use yii\bootstrap\Modal;
use yii\bootstrap\Button;

?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'options' => [
        'id' => 'cafe_form',
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
    <div class="row">
        <div class="col-sm-6">
<!--            --><?//= $form->field($formModel, 'frontend')->widget(SwitchInput::className(), []) ?>
        </div>
    </div>

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
            <?= $form->field($formModel, 'translationSpellings[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textInput()->label(
                $formModel->getAttributeLabel('translationSpellings').', '.$language->name
            );?>
        </div>
    </div>
    <?endforeach;?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'rest_net') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?=$form->field($formModel, 'region_id')->dropDownList(ArrayHelper::map(Region::find()->all(), 'id', 'name'), [
                'id'=>'cafeform-region_id',
                'prompt' => $formModel->getAttributeLabel('region_id'),
            ])?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'province_id')->widget(DepDrop::classname(), [
                'id'=>'cafeform-province_id',
                'data'=> ArrayHelper::map(Province::find()->where(['region_id'=>$formModel->region_id])->all(), 'id', 'name'),
                'options'=>[
                    'prompt' => $formModel->getAttributeLabel('province_id'),
                ],
                'pluginOptions'=>[
                    'depends'=>['cafeform-region_id'],
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
                    'depends'=>['cafeform-region_id', 'cafeform-province_id'],
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
            <?= $form->field($formModel, 'address') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($formModel, 'latitude') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($formModel, 'longitude') ?>
        </div>
        <div class="col-sm-2">
            <div style="padding-top: 27px">
            <?php
                echo \modules\base\widgets\map\GoogleMap::widget([
                    'id_latitude' => 'cafeform-latitude',
                    'id_longitude' => 'cafeform-longitude',
                    'latitude' => $formModel->latitude,
                    'longitude' => $formModel->longitude,
                ]);
            ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'placement_id')->dropDownList(ArrayHelper::map(Placement::find()->all(), 'id', 'name')); ?>
        </div>
    </div>
    <?foreach($languages as $language):?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($formModel, 'translationWorktime[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textInput()->label(
                    $formModel->getAttributeLabel('translationWorktime').', '.$language->name
                );?>
            </div>
        </div>
    <?endforeach;?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'site') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'facebook') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'instagram') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?
            $initialPreview = [];
            $previewConfig = [];
            if($formModel->logo_image){
                $initialPreview[] = '<img src="'.$formModel->logo_image->getSrc().'" alt="" class="file-preview-image">';
                $previewConfig[] = [
                    'url' => Url::toRoute(['image-delete']),
                    'key' => $formModel->logo_image->id,
                ];
            }
            ?>
            <?= $form->field($formModel, 'logo_image')->widget(BootstrapFileInput::className(), [
                'options' => ['accept' => 'image/*'],
                'clientOptions' => [
                    'browseClass' => 'btn btn-success',
                    'uploadClass' => 'btn btn-info',
                    'removeClass' => 'btn btn-danger',
                    'removeIcon' => '<i class="glyphicon glyphicon-trash"></i> ',
                    'showUpload' => false,
                    'initialPreview' => $initialPreview,
                    'initialPreviewConfig' => $previewConfig,
                    'showRemove' => false,
                ]
            ])->error(false);?>
        </div>
    </div>

<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Module::t('cafe', 'BACKEND_CREATE_SUBMIT') : Module::t(
        'cafe',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>