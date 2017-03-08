<?php

use SlimRunner\AppConfig as AppConfig;

require_once 'script_bootstrap.php';

$progObj = $db->loadModel('Programs');


$shows = ($progObj->getDistinctTitles(AppConfig::get('channels', 'channelIndexList')));

foreach ($shows as $show)
{
    Resque::enqueue(AppConfig::get('redis', 'queue'), 'ResqueShowInfo', ['title'=>$show['title'], 'season'=>$show['season_id']]);
}