<?php

use SlimRunner\AppConfig as AppConfig;

define('APPLICATION_PATH', dirname(__FILE__));

require_once APPLICATION_PATH.'/vendor/autoload.php';

AppConfig::load(APPLICATION_PATH.'/config.ini');

date_default_timezone_set(AppConfig::get('datetime', 'timezone', 'GMT'));

Resque::setBackend(AppConfig::get('redis', 'server'));
Logger::setLogFile(APPLICATION_PATH.'/cache/logfile.log');