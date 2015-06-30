<?php

use modules\directory\Module;
use vova07\imperavi\Widget as Imperavi;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\base\components\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\switchinput\SwitchInput;
use dosamigos\fileinput\BootstrapFileInput;
use kartik\depdrop\DepDrop;
use modules\directory\models\RoomType;
use modules\directory\models\City;
use modules\translations\models\Lang;
use modules\directory\models\Placement;

?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'options' => [
        'id' => 'room_form',
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
            <?= $form->field($formModel, 'active')->widget(SwitchInput::className(), []) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?=$form->field($formModel, 'placement_id')->dropDownList(ArrayHelper::map(Placement::find()->all(), 'id', 'name'), [
                'id'=>'placement-placement_type_id',
                'prompt' => $formModel->getAttributeLabel('placement_id'),
            ])?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'building')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'room_type_id')
                ->dropDownList(
                    ['', '!!! Задача по созданию опций номеров']
                );
             ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'area')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'bed')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'capacity')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'price')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($formModel, 'time')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?
            if($formModel->main_image){
                $initialMainPreview[] = '<img src="'.$formModel->main_image->getSrc().'" alt="" width="100px" height="100px">';
                $previewMainConfig[] = [
//                'width' => '100px',
//                'height' => '100px',
//                'url' => Url::toRoute(['image-delete']),
//                'key' => $formModel->image->id,
                ];
            }
            else{
                $initialMainPreview = [];
                $previewMainConfig = [];
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
                    'initialPreview' => $initialMainPreview,
                    'initialPreviewConfig' => $previewMainConfig,
                    'initialPreviewShowDelete' => false,
                ]
            ])->error(false);?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?
            if($formModel->add_image){
                $initialPreview[] = '<img src="'.$formModel->main_image->getSrc().'" alt="" width="100px" height="100px">';
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
            <?= $form->field($formModel, 'add_image')->widget(BootstrapFileInput::className(), [
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

    <?
    $languages = Lang::find()->all();
    foreach($languages as $language):?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($formModel, 'desc_short_translate[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textArea()->label(
                    $formModel->getAttributeLabel('desc_short_translate').', '.$language->name
                );?>
            </div>
        </div>
    <?endforeach;?>

    <?
    $languages = Lang::find()->all();
    foreach($languages as $language):?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($formModel, 'desc_full_translate[' . $language->id . ']', ['options' => ['class' => 'form-group']])->textArea()->label(
                    $formModel->getAttributeLabel('desc_full_translate').', '.$language->name
                );?>
            </div>
        </div>
    <?endforeach;?>

<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Module::t('placement-type', 'BACKEND_CREATE_SUBMIT') : Module::t(
        'placement-type',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>