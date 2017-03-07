<?php
/**
 * Created by PhpStorm.
 * User: tohir.solomons
 * Date: 2017/03/07
 * Time: 10:35 AM
 */

class Resque_ChannelParser extends ResqueHackathon
{

    public function perform()
    {
        Logger::log(print_r($this->args, true), __FILE__, __LINE__, __METHOD__);


        $packages = $this->db->loadModel('Packages');


        Logger::log(print_r($packages->getAll(), true), __FILE__, __LINE__, __METHOD__);
    }

}