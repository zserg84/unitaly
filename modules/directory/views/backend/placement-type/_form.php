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
use modules\directory\models\PlacementType;
use modules\directory\models\City;
use modules\translations\models\Lang;
use Yii;

?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'options' => [
        'id' => 'placement_type_form',
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
            if($formModel->image){
                $initialPreview[] = '<img src="'.$formModel->image->getSrc().'" alt="" class="file-preview-image">';
                $previewConfig[] = [
                    'url' => Url::toRoute(['image-delete']),
                    'key' => $formModel->image->id,
                ];
            }
            else{
                $initialPreview = [];
                $previewConfig = [];
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