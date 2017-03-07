<?php
/**
 * Created by PhpStorm.
 * User: tohir.solomons
 * Date: 2017/03/07
 * Time: 10:02 AM
 */

class AppDB extends \Tohir\Database
{
    public function getTestData()
    {
        return $this->db->select('test');
    }

    public function getAllUsers()
    {
        return $this->db->select('tbl_users', array('isactive'=>'1'));
    }
}

