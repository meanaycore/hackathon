<?php

use SlimRunner\AppConfig as AppConfig;

require_once 'script_bootstrap.php';

$progInfo = $db->loadModel('ProgramInfo');

$titles = $progInfo->getDistinctTitles();

foreach ($titles as $show)
{
    Resque::enqueue(AppConfig::get('redis', 'queue'), 'ResqueShowInfo', ['programid'=>$show['programid']]);
}