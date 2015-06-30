<?php

/**
 * User form view.
 *
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \vova07\users\models\backend\User $model Model
 * @var \vova07\users\models\Profile $profile Profile
 * @var array $roleArray Roles array
 * @var array $statusArray Statuses array
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 */

use vova07\fileapi\Widget;
use modules\users\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'id' => 'user-form',
]); ?>
<?php $box->beginBody(); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($profile, 'name') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($profile, 'surname') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($user, 'username') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($user, 'email') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($user, 'password')->passwordInput() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($user, 'repassword')->passwordInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?=
            $form->field($user, 'status_id')->dropDownList(
                $statusArray,
                [
                    'prompt' => Module::t('users', 'BACKEND_PROMPT_STATUS')
                ]
            ) ?>
        </div>
        <div class="col-sm-6">
            <?=
            $form->field($user, 'role')->dropDownList(
                $roleArray,
                [
                    'prompt' => Module::t('users', 'BACKEND_PROMPT_ROLE')
                ]
            ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($profile, 'avatar_url')->widget(Widget::className(),
                [
                    'settings' => [
                        'url' => ['fileapi-upload']
                    ],
                    'crop' => true,
                    'cropResizeWidth' => 100,
                    'cropResizeHeight' => 100
                ]
            ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?
            $roles = Yii::$app->authManager->getRoles();
            $roles = ArrayHelper::map($roles, 'name', 'name');
            echo $form->field($user, 'role')->dropDownList($roles, [
                'onchange' => '
                    var url = "'.Url::toRoute(['get-permissions-by-role']).'";
                    var role = $(this).val();
                    $.pjax({url: url, container: "#pjax-permissions-container", data:{role: role}, push:false, replace:false})
                ',
            ]);
            ?>
        </div>
    </div>
<?
echo $this->render('_permission_list', [
    'user' => $user,
]);?>
<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $user->isNewRecord ? Module::t('users', 'BACKEND_CREATE_SUBMIT') : Module::t('users', 'BACKEND_UPDATE_SUBMIT'),
    [
        'class' => $user->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>