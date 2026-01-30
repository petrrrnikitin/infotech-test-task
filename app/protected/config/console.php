<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return [
	'basePath'=> dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=> ['log'],

	// autoloading model and component classes
	'import'=> [
		'application.models.*',
		'application.components.*',
		'application.services.*',
		'application.exceptions.*',
		'application.jobs.*',
    ],

	// application components
	'components'=> [

		'db'=> require(dirname(__FILE__) . '/database.php'),

		'log'=> [
			'class'=>'CLogRouter',
			'routes'=> [
				[
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, info',
                ],
            ],
        ],

        'queue' => [
            'class' => 'application.components.QueueComponent',
            'host' => getenv('RABBITMQ_HOST'),
            'port' => (int) getenv('RABBITMQ_PORT') ?: 5672,
            'user' => getenv('RABBITMQ_USER'),
            'password' => getenv('RABBITMQ_PASSWORD'),
        ],
        'smsPilot' => [
            'class' => 'application.components.SmsPilotClient',
            'apiKey' => getenv('SMSPILOT_API_KEY'),
        ],

    ],
];
