<?php

namespace modules\users\models;

use vova07\users\helpers\Security;
use modules\users\Module as UserModule;;
use Yii;

/**
 * Class User
 * @package vova07\users\models
 * User model.
 *
 * @property integer $id ID
 * @property string $username Username
 * @property string $email E-mail
 * @property string $password_hash Password hash
 * @property string $auth_key Authentication key
 * @property string $role Role
 * @property integer $status_id Status
 * @property integer $created_at Created time
 * @property integer $updated_at Updated time
 *
 * @property Profile $profile Profile
 */
class User extends \vova07\users\models\User
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => UserModule::t('users', 'USERNAME'),
            'email' => UserModule::t('users', 'EMAIL'),
            'role' => UserModule::t('users', 'ROLE'),
            'created_at' => UserModule::t('users', 'CREATED_AT'),
            'updated_at' => UserModule::t('users', 'UPDATED_AT'),
            'status_id' => UserModule::t('users', 'STATUS_ID'),
        ];
    }

    /**
     * @return Profile|null User profile
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id'])->inverseOf('user');
    }
}
