<?php

use SlimRunner\AppConfig as AppConfig;

require_once 'script_bootstrap.php';

$genresDb = $db->loadModel('Genres');

var_dump($genresDb->getAll());
