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
        'id' => 'supermarket_form',
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
                'id'=>'shopsupermarketform-region_id',
                'prompt' => $formModel->getAttributeLabel('region_id'),
            ])?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'province_id')->widget(DepDrop::classname(), [
                'id'=>'shopsupermarketform-province_id',
                'data'=> ArrayHelper::map(Province::find()->where(['region_id'=>$formModel->region_id])->all(), 'id', 'name'),
                'options'=>[
                    'prompt' => $formModel->getAttributeLabel('province_id'),
                ],
                'pluginOptions'=>[
                    'depends'=>['shopsupermarketform-region_id'],
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
                    'depends'=>['shopsupermarketform-region_id', 'shopsupermarketform-province_id'],
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
                    'id_latitude' => 'shopsupermarketform-latitude',
                    'id_longitude' => 'shopsupermarketform-longitude',
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
                ]); ?>
        </div>
    </div>

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