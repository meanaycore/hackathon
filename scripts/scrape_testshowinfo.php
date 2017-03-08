<?php

use SlimRunner\AppConfig as AppConfig;

require_once 'script_bootstrap.php';

$progId = 'b0fd2da5-1634-40ab-abde-8787fbd4f064';
$progId = '6f7103d0-802f-4fb9-b750-f199aa63e2c2';


Resque::enqueue(AppConfig::get('redis', 'queue'), 'ResqueShowInfo', ['programid'=>$progId]);