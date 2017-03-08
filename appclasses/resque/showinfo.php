<?php
/**
 * Created by PhpStorm.
 * User: tohir.solomons
 * Date: 2017/03/07
 * Time: 10:35 AM
 */

use SlimRunner\AppConfig as AppConfig;

class Resque_ShowInfo extends ResqueHackathon
{

    public function perform()
    {
        Logger::log(print_r($this->args, true), __FILE__, __LINE__, __METHOD__);


    }

}