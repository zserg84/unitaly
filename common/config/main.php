<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Europe/Moscow',
    'modules' => [
        'users' => [
            'class' => 'modules\users\Module',
            'robotEmail' => 'no-reply@domain.com',
            'robotName' => 'Robot'
        ],
        /*'blogs' => [
            'class' => 'vova07\blogs\Module'
        ],
        'comments' => [
            'class' => 'vova07\comments\Module'
        ],*/
        'directory' => [
            'class' => modules\directory\Module::className(),
        ],
        'image' => [
            'class' => modules\image\Module::className(),
            'path' => Yii::getAlias('@statics').'/web/img/',
            'url' => '/web/img/',
            'sizeArray' => [100, 200, 500, 1000],
        ],
        'translations' => [
            'class' => modules\translations\Module::className(),
        ],
        'gridview' => [
            'class' => \kartik\grid\Module::className(),
        ],
        'base' => [
            'class' => modules\base\Module::className(),
        ],
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ]
    ],
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'vova07\users\models\User',
            'loginUrl' => ['/users/guest/login']
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@root/cache',
            'keyPrefix' => 'yii2start'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'suffix' => '/'
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
        'authManager' => [
            'defaultRoles' => [
                'user'
            ],
            /*'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_item}}',
            'itemChildTable' => '{{%auth_item_child}}',
            'assignmentTable' => '{{%auth_assignment}}',
            'ruleTable' => '{{%auth_rule}}',*/

            'class' => 'yii\rbac\PhpManager',
            'itemFile' => '@modules/rbac/data/items.php',
            'assignmentFile' => '@modules/rbac/data/assignments.php',
            'ruleFile' => '@modules/rbac/data/rules.php',
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.y',
            'datetimeFormat' => 'HH:mm:ss dd.MM.y'
        ],
        'i18n' => [
            'class' => modules\translations\components\I18N::className(),
        ],
        'db' => require(__DIR__ . '/db.php'),
//        'language'=>'ru-RU',
//        'sourceLanguage' => 'en-US',
    ],
    'params' => require(__DIR__ . '/params.php')
];
