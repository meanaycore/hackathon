<?php

use SlimRunner\AppConfig as AppConfig;

abstract class ResqueHackathon
{

    public function setUp()
    {
        $this->db = new AppDB(AppConfig::get('database', 'server'), AppConfig::get('database', 'dbname'), AppConfig::get('database', 'dbuser'), AppConfig::get('database', 'dbpass'));
    }

    abstract function perform();

    protected function getArrayValue($array, $key, $default=null)
    {
        if (isset($array[$key])) {
            $value = $array[$key];
        } else {
            $value = $default;
        }

        if ($value == 'N/A') {
            $value = $default;
        }

        return $value;
    }


    protected function convertToPiped($string)
    {
        if (empty($string)) {
            return $string;
        }

        $string = str_replace(', ', '|', $string);

        return '|'.$string.'|';
    }

}