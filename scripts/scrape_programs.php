<?php

use SlimRunner\AppConfig as AppConfig;

require_once 'script_bootstrap.php';

$genresDb = $db->loadModel('Genres');

$genres = $genresDb->getIndexableGenres();

$date = date('Y-m-d');

foreach ($genres as $genre)
{
    Resque::enqueue(AppConfig::get('redis', 'queue'), 'Resque_ProgramParser', ['genre'=>$genre['name'], 'date'=>$date]);
}
