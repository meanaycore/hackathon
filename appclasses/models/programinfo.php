<?php

class DBModel_ProgramInfo extends \Tohir\DBModel
{

    /**
     * @var string Name of Table
     */
    protected $tableName = 'programinfo';

    /**
     * @var string Primary of Table
     */
    protected $primaryKey = 'id';

    /**
     * @var string The column holding the Date Inserted Field - auto populated if set
     */
    protected $dateInsertColumn = 'date_created';

    /**
     * @var string The column holding the Date Updated Field - auto populated if set
     */
    protected $dateUpdateColumn = 'date_updated';

    protected $tableColumns = [
            'programid',
            'title',
            'description',
            'programimage',
            'programtype',
            'imdb_id',
            'imdb_rating',
            'season_id',
            'episode_id',
        ];

    public function hasProgramme($progId, $date, $time, $channel)
    {
        $result = $this->db->select($this->tableName, ['programid'=>$progId, 'program_date'=>$date, 'starttime'=>$time, 'channel_tag'=>$channel]);

        if (count($result) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}