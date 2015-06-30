<?php

use modules\themes\Module as ThemeModule;
use modules\directory\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use modules\directory\models\ShopType;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'options' => [
        'id' => 'shop_form',
    ]
]); ?>
<?php $box->beginBody(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?=$form->field($formModel, 'shop_type_id')->dropDownList(ArrayHelper::map(ShopType::find()->all(), 'id', 'name'), [
                'prompt' => $formModel->getAttributeLabel('shop_type_id'),
            ])?>
        </div>
    </div>

<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    Module::t('shop', 'BACKEND_NEXT'),
    [
        'class' => 'btn btn-primary btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>