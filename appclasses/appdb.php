<?php
/**
 * Created by PhpStorm.
 * User: tohir.solomons
 * Date: 2017/03/07
 * Time: 10:02 AM
 */

class AppDB extends \Tohir\Database
{
    public function getProgramSchedule($title)
    {
        $sql = <<<SQL
SELECT 

channels.channelname,
channels.channelnumber,
programschedule.channel_tag, 
programschedule.program_date, 
programschedule.starttime, 
programinfo.season_id, 
programinfo.episode_id, 
programinfo.description

FROM programschedule
INNER JOIN programinfo ON (programschedule.programid = programinfo.programid)
INNER JOIN channels ON (programschedule.channel_tag = channels.channeltag)

 WHERE programschedule.title = :title
SQL;

        return $this->db->query($sql, ['title' => $title]);

    }
}

