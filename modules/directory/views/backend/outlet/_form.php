<?php

use modules\themes\Module as ThemeModule;
use modules\directory\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\switchinput\SwitchInput;
use kartik\depdrop\DepDrop;
use modules\base\widgets\map\GoogleMap;
use modules\base\components\ActiveForm;
use yii\helpers\ArrayHelper;
use modules\directory\models\Region;
use modules\directory\models\Province;
use modules\directory\models\City;
use modules\translations\models\Lang;
use modules\directory\models\GoodCategory;
use dosamigos\fileinput\BootstrapFileInput;
use nex\chosen\Chosen;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'options' => [
        'id' => 'outlet_form',
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
            <?= $form->field($formModel, 'frontend')->widget(SwitchInput::className(), []) ?>
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
            <?=$form->field($formModel, 'region_id')->dropDownList(ArrayHelper::map(Region::find()->all(), 'id', 'name'), [
                'id'=>'shopoutletform-region_id',
                'prompt' => $formModel->getAttributeLabel('region_id'),
            ])?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'province_id')->widget(DepDrop::classname(), [
                'id'=>'shopoutletform-province_id',
                'data'=> ArrayHelper::map(Province::find()->where(['region_id'=>$formModel->region_id])->all(), 'id', 'name'),
                'options'=>[
                    'prompt' => $formModel->getAttributeLabel('province_id'),
                ],
                'pluginOptions'=>[
                    'depends'=>['shopoutletform-region_id'],
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
                    'depends'=>['shopoutletform-region_id', 'shopoutletform-province_id'],
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
                echo GoogleMap::widget([
                    'id_latitude' => 'shopoutletform-latitude',
                    'id_longitude' => 'shopoutletform-longitude',
                    'latitude' => $formModel->latitude,
                    'longitude' => $formModel->longitude,
                ]);
                ?>
            </div>
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
            <?= $form->field($formModel, 'phone') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'phone_additional') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'phone_additional_comment') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'fax') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'email') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'network') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?$categories = GoodCategory::find()->all();?>
            <?= $form->field($formModel, 'categories')->widget(
                Chosen::className(), [
                    'items' => ArrayHelper::map($categories, 'id', 'name'),
                    'multiple' => true,
                    'placeholder' => Module::t('shop', 'Select some options'),
                ]); ?>
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
    <div class="row">
        <div class="col-sm-6">
            <?
            $initialPreview = [];
            $previewConfig = [];
            if($formModel->main_image){
                $initialPreview[] = '<img src="'.$formModel->main_image->getSrc().'" alt="" class="file-preview-image">';
                $previewConfig[] = [
                    'url' => Url::toRoute(['image-delete']),
                    'key' => $formModel->main_image->id,
                ];
            }
            ?>
            <?= $form->field($formModel, 'main_image')->widget(BootstrapFileInput::className(), [
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
            if($formModel->additional_image){
                $initialPreview[] = '<img src="'.$formModel->additional_image->getSrc().'" alt="" class="file-preview-image">';
                $previewConfig[] = [
                    'url' => Url::toRoute(['image-delete']),
                    'key' => $formModel->additional_image->id,
                ];
            }
            ?>
            <?= $form->field($formModel, 'additional_image')->widget(BootstrapFileInput::className(), [
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
    <?foreach($languages as $language):?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($formModel, 'translationShortDescription[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textarea()->label(
                    $formModel->getAttributeLabel('translationShortDescription').', '.$language->name
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
    $model->isNewRecord ? Module::t('shop', 'BACKEND_CREATE_SUBMIT') : Module::t(
        'shop',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>