<?php

use SlimRunner\AppConfig as AppConfig;

require_once 'script_bootstrap.php';

$genresDb = $db->loadModel('Genres');

$genres = $genresDb->getIndexableGenres();

foreach ($genres as $genre)
{
    Resque::enqueue(AppConfig::get('redis', 'queue'), 'ResqueChannelParser', ['genre'=>$genre['name']]);
}
