<?php

namespace modules\users\models;

use modules\users\Module as UserModule;
use Yii;


class Profile extends \vova07\users\models\Profile
{


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => UserModule::t('users', 'NAME'),
            'surname' => UserModule::t('users', 'SURNAME'),
            'avatar_url' => UserModule::t('users', 'AVATAR_URL'),
        ];
    }
}
