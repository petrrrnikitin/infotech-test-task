<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return [
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=> ['log'],

	// autoloading model and component classes
	'import'=> [
		'application.models.*',
		'application.components.*',
		'application.services.*',
		'application.exceptions.*',
    ],

	'modules'=> [
		'gii'=> [
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// Allow all IPs for Docker environment
			'ipFilters'=> ['*'],
        ],
    ],

	// application components
	'components'=> [

		'user'=> [
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
        ],

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'db'=> require(dirname(__FILE__) . '/database.php'),

		'errorHandler'=> [
			'errorAction'=>YII_DEBUG ? null : 'site/error',
        ],

		'log'=> [
			'class'=>'CLogRouter',
			'routes'=> [
				[
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
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

    ],

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=> [
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
    ],
];
