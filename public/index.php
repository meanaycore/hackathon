<?php

define('APPLICATION_PATH', realpath(dirname(__FILE__).'/..'));

require_once APPLICATION_PATH.'/vendor/autoload.php';

$appRun = new AppRun(APPLICATION_PATH.'/config.ini', APPLICATION_PATH.'/cache/');

$appRun->run();
