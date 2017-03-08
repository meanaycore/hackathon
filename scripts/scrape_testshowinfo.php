<?php

use SlimRunner\AppConfig as AppConfig;

require_once 'script_bootstrap.php';

$progId = 'b0fd2da5-1634-40ab-abde-8787fbd4f064';


Resque::enqueue(AppConfig::get('redis', 'queue'), 'Resque_ShowInfo', ['programid'=>$progId]);