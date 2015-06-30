<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use modules\translations\Module;
use modules\translations\models\Message;
use modules\translations\models\Lang;

$form = ActiveForm::begin(); ?>
<?php $box->beginBody(); ?>
    <div class="row">
        <?
        $languages = Lang::find()->all();
        $messages = $model->messages;
        foreach($languages as $language){
            $message = isset($messages[$language->id]) ? $messages[$language->id] : new Message();
            echo $form->field($message, '[' . $language->id . ']translation', ['options' => ['class' => 'form-group col-sm-6']])->textInput()->label($language->name);
        }
        ?>
    </div>
<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Module::t('translations', 'BACKEND_CREATE_SUBMIT') : Module::t(
        'translations',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php $form::end(); ?>