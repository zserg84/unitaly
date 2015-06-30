<?php

use modules\directory\Module;
use vova07\imperavi\Widget as Imperavi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\switchinput\SwitchInput;
use dosamigos\fileinput\BootstrapFileInput;
use kartik\depdrop\DepDrop;
use modules\directory\models\Region;
use modules\directory\models\City;
use modules\translations\models\Lang;
use yii\bootstrap\Modal;
use yii\bootstrap\Button;
use modules\directory\models\Province;

?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'options' => [
        'id' => 'restaurant_form',
        'enctype' => 'multipart/form-data',
    ]
]); ?>
<?php $box->beginBody(); ?>

    <?php if ($this->context->action->id != 'create'): ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'id')->input('text', ['disabled' => 'disabled']) ?>
        </div>
    </div>
    <?endif;?>

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

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'spellings')->textarea() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'rest_net') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'restaurant_type_id')
                ->dropDownList(
                    ['', '!!! задача по типам ресторанов']
                );
             ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'stars')
                ->dropDownList(
                    ['', '1*', '2*', '3*', '4*', '5*']
                );
             ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?=$form->field($formModel, 'region_id')->dropDownList(ArrayHelper::map(Region::find()->all(), 'id', 'name'), [
                'id'=>'restform-region_id',
                'prompt' => $formModel->getAttributeLabel('region_id'),
            ])?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'province_id')->widget(DepDrop::classname(), [
                'id'=>'restform-province_id',
                'data'=> ArrayHelper::map(Province::find()->where(['region_id'=>$formModel->region_id])->all(), 'id', 'name'),
                'options'=>[
                    'prompt' => $formModel->getAttributeLabel('province_id'),
                ],
                'pluginOptions'=>[
                    'depends'=>['restform-region_id'],
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
//                    'id'=>'showplaceform-city',
                    'prompt' => $formModel->getAttributeLabel('city_id'),
                ],
                'pluginOptions'=>[
                    'depends'=>['restform-region_id'],
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
        <div class="col-sm-2">
            <?= $form->field($formModel, 'latitude') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($formModel, 'longitude') ?>
        </div>
        <div class="col-sm-2">
            <div style="padding-top: 27px">
        <?php
            Modal::begin([
                'header' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3053568.2776701897!2d13.924929151629998!3d41.634125571647814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12d4fe82448dd203%3A0xe22cf55c24635e6f!2z0JjRgtCw0LvQuNGP!5e0!3m2!1sru!2sru!4v1433847176183" width="570" height="600" frameborder="0" style="border:0"></iframe>',
                'toggleButton' => [
                    'label' => 'Указать на карте'
                ],
                'size' => Modal::SIZE_LARGE
            ]);

            echo Button::widget([
                'label' => 'Ok',
                'options' => [
                    'class' => 'btn-lg',
                    'onclick' => 'alert("save point"); return false;'
                ],
            ]);

            Modal::end();
        ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?
            if($formModel->logo_image){
                $initialPreview[] = '<img src="'.$formModel->logo_image->getSrc().'" alt="" width="100px" height="100px">';
                $previewConfig[] = [
//                'width' => '100px',
//                'height' => '100px',
//                'url' => Url::toRoute(['image-delete']),
//                'key' => $formModel->image->id,
                ];
            }
            else{
                $initialPreview = [];
                $previewConfig = [];
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
                    'initialPreviewShowDelete' => false,
                ]
            ])->error(false);?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?
            if($formModel->menu_image){
                $initialMenuPreview[] = '<img src="'.$formModel->menu_image->getSrc().'" alt="" width="100px" height="100px">';
                $previewConfig[] = [
//                'width' => '100px',
//                'height' => '100px',
//                'url' => Url::toRoute(['image-delete']),
//                'key' => $formModel->image->id,
                ];
            }
            else{
                $initialMenuPreview = [];
                $previewConfig = [];
            }
            ?>
            <?= $form->field($formModel, 'menu_image')->widget(BootstrapFileInput::className(), [
                'options' => ['accept' => 'image/*'],
                'clientOptions' => [
                    'browseClass' => 'btn btn-success',
                    'uploadClass' => 'btn btn-info',
                    'removeClass' => 'btn btn-danger',
                    'removeIcon' => '<i class="glyphicon glyphicon-trash"></i> ',
                    'showUpload' => false,
                    'initialPreview' => $initialMenuPreview,
                    'initialPreviewConfig' => $previewConfig,
                    'initialPreviewShowDelete' => false,
                ]
            ])->error(false);?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'address')->textarea() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'hotel_id')
                ->dropDownList(
                    $model->getHotelList()
                );
             ?>
        </div>
    </div>

    <?
    $languages = Lang::find()->all();
    foreach($languages as $language):?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($formModel, 'translationWorktime[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textarea()->label(
                    $formModel->getAttributeLabel('translationWorktime').', '.$language->name
                );?>
            </div>
        </div>
    <?endforeach;?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'main_phone') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'add_phone') ?>
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

<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Module::t('restaurant', 'BACKEND_CREATE_SUBMIT') : Module::t(
        'restaurant',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>