<?php

use SlimRunner\AppConfig as AppConfig;

require_once 'script_bootstrap.php';

$genresDb = $db->loadModel('Genres');

$genres = $genresDb->getIndexableGenres();

$numberOfDays = 2;

$date = date('Y-m-d');

foreach ($genres as $genre)
{

    for($i=0;$i<=$numberOfDays;$i++)
    {
        $date = date('Y-m-d', strtotime(' +'.$i.' day'));
        Resque::enqueue(AppConfig::get('redis', 'queue'), 'ResqueProgramParser', ['genre'=>$genre['name'], 'date'=>$date]);
    }


}
