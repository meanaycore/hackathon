<?php

use SlimRunner\AppConfig as AppConfig;

require_once 'script_bootstrap.php';

$progId = '2d282d02-6166-4de6-a4df-12848b636083';


Resque::enqueue(AppConfig::get('redis', 'queue'), 'Resque_ProgramInfo', ['programid'=>$progId]);