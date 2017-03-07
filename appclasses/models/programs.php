<?php

class DBModel_Programs extends \Tohir\DBModel
{

    /**
     * @var string Name of Table
     */
    protected $tableName = 'programschedule';

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
            'channel_tag',
            'title',
            'program_date',
            'starttime',
            'endtime',
            'programtype',
            'imdb_id',
            'episode_id',
        ];

    public function getByProgramId($progId)
    {
        return $this->getRow('programid', $progId);
    }
}