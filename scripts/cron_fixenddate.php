<?php

use SlimRunner\AppConfig as AppConfig;

require_once 'script_bootstrap.php';

$programsObj = $db->loadModel('Programs');

$shows = $programsObj->getForEndDateFix();

$currentChannel = null;
$lastStart = null;

foreach ($shows as $show)
{
    if ($show['channel_tag'] != $currentChannel) {
        $lastStart = null;
        $currentChannel = $show['channel_tag'];
    }

    if (empty($lastStart)) {
        $lastStart = $show['starttime'];
        continue;
    } else {

        $programsObj->update($show['id'], ['endtime'=>$lastStart]);

        $lastStart = $show['starttime'];

    }
}