<?php

namespace modules\users\models;

use modules\users\Module as UserModule;
use vova07\users\traits\ModuleTrait;
use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package vova07\users\models
 * LoginForm is the model behind the login form.
 *
 * @property string $username Username
 * @property string $password Password
 * @property boolean $rememberMe Remember me
 */
class LoginForm extends \vova07\users\models\LoginForm
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => UserModule::t('users', 'USERNAME'),
            'password' => UserModule::t('users', 'PASSWORD'),
            'rememberMe' => UserModule::t('users', 'REMEMBER_ME')
        ];
    }
}
