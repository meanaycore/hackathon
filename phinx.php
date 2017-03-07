<?php

define('APPLICATION_PATH', realpath(dirname(__FILE__).'/'));
require_once APPLICATION_PATH.'/vendor/autoload.php';

use SlimRunner\AppConfig as AppConfig;
AppConfig::load(APPLICATION_PATH.'/config.ini');

$result = [
    'paths' => [
        'migrations' => APPLICATION_PATH.'/phinx_migrations'
    ],
    'environments' => [
        'default_migration_table' => 'phinx_migration_log',
        'default_database' => AppConfig::get('database', 'environment'),
        
        AppConfig::get('database', 'environment') => [
            'adapter'   => AppConfig::get('database', 'type'),
            'host'      => AppConfig::get('database', 'server'),
            'name'      => AppConfig::get('database', 'dbname'),
            'user'      => AppConfig::get('database', 'dbuser'),
            'pass'      => AppConfig::get('database', 'dbpass'),
            'port'      => AppConfig::get('database', 'port')
        ]
    ]
];


var_dump($result);

return $result;