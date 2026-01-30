<?php

// This is the database connection configuration.
return [
    'connectionString' => sprintf(
        'mysql:host=%s;dbname=%s',
        getenv('DB_HOST'),
        getenv('DB_NAME')
    ),
    'emulatePrepare' => true,
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8',
];
