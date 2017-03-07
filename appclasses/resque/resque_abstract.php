<?php

use SlimRunner\AppConfig as AppConfig;

abstract class ResqueHackathon
{

    public function setUp()
    {
        $this->db = new AppDB(AppConfig::get('database', 'server'), AppConfig::get('database', 'dbname'), AppConfig::get('database', 'dbuser'), AppConfig::get('database', 'dbpass'));
    }

    abstract function perform();

}