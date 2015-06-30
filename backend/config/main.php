<?php

Yii::setAlias('backend', dirname(__DIR__));

return [
    'id' => 'app-backend',
    'name' => 'Unitaly',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'admin/default/index',
    'modules' => [
        'admin' => [
            'class' => \modules\admin\Module::className(),
        ],
        'users' => [
            'controllerNamespace' => 'modules\users\controllers\backend'
        ],
        'blogs' => [
            'isBackend' => true
        ],
        'comments' => [
            'isBackend' => true
        ],
        'rbac' => [
            'class' => 'vova07\rbac\Module',
            'isBackend' => true
        ],
        'directory' => [
            'controllerNamespace' => 'modules\directory\controllers\backend',
            'isBackend' => true,
        ],
        'translations' => [
            'class' => modules\translations\Module::className(),
            'controllerNamespace' => 'modules\translations\controllers\backend',
            'isBackend' => true,
        ],
        'base' => [
            'controllerNamespace' => 'modules\base\controllers\backend',
            'isBackend' => true,
        ],
    ],
    'components' => [
        'request' => [
            'class' => \modules\base\components\LangRequest::className(),
            'cookieValidationKey' => '7fdsf%dbYd&djsb#sn0mlsfo(kj^kf98dfh',
//            'baseUrl' => '/backend'
        ],
        'urlManager' => [
            'rules' => [
                '' => 'admin/default/index',
                '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>',
            ]
        ],
        'view' => [
            'theme' => \modules\themes\admin\Theme::className(),
        ],
        'errorHandler' => [
            'errorAction' => 'admin/default/error'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ]
            ]
        ],
    ],
    'params' => require(__DIR__ . '/params.php')
];
