<?php

define('APPLICATION_PATH', realpath(dirname(__FILE__).'/..'));

require_once APPLICATION_PATH.'/vendor/autoload.php';

use SlimRunner\AppConfig as AppConfig;
AppConfig::load(APPLICATION_PATH.'/config.ini');

$db = new AppDB(AppConfig::get('database', 'server'), AppConfig::get('database', 'dbname'), AppConfig::get('database', 'dbuser'), AppConfig::get('database', 'dbpass'));