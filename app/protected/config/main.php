<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return [
    'basePath' => __DIR__ . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Web Application',

    // preloading 'log' component
    'preload' => ['log'],

    // autoloading model and component classes
    'import' => [
        'application.models.*',
        'application.components.*',
        'application.services.*',
        'application.exceptions.*',
        'application.dto.*',
        'application.jobs.*',
    ],

    'modules' => [
        'gii' => [
            'class' => 'system.gii.GiiModule',
            'password' => getenv('GII_PASSWORD'),
            'ipFilters' => ['127.0.0.1', '::1'],
        ],
    ],

    // application components
    'components' => [

        'user' => [
            'class' => 'WebUser',
            'allowAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],

        'request' => [
            'enableCsrfValidation' => true,
            'csrfTokenName' => 'csrf_token',
        ],

        'urlManager' => [
            'urlFormat' => 'path',
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],

        'db' => require __DIR__ . '/database.php',

        'errorHandler' => [
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ],

        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ],
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ],
        ],

        'bookService' => [
            'class' => 'application.services.BookService',
        ],
        'authorService' => [
            'class' => 'application.services.AuthorService',
        ],
        'userService' => [
            'class' => 'application.services.UserService',
        ],
        'authManager' => [
            'class' => 'CPhpAuthManager',
            'authFile' => __DIR__ . '/auth.php',
        ],
        'fileUploader' => [
            'class' => 'application.components.FileUploader',
            'baseUploadPath' => '/var/www/html/uploads',
            'maxFileSize' => 5 * 1024 * 1024, // 5MB
            'allowedExtensions' => ['jpg', 'jpeg', 'png'],
        ],
        'subscriptionService' => [
            'class' => 'application.services.SubscriptionService',
        ],
        'queue' => [
            'class' => 'application.components.QueueComponent',
            'host' => getenv('RABBITMQ_HOST'),
            'port' => (int)getenv('RABBITMQ_PORT'),
            'user' => getenv('RABBITMQ_USER'),
            'password' => getenv('RABBITMQ_PASSWORD'),
        ],
        'smsPilot' => [
            'class' => 'application.components.SmsPilotClient',
            'apiKey' => getenv('SMSPILOT_API_KEY'),
        ],

    ],

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => [
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ],
];
