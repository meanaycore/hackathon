<?php

class DBModel_ShowInfo extends \Tohir\DBModel
{

    /**
     * @var string Name of Table
     */
    protected $tableName = 'showinfo';

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
            'title',
            'shorturl',
            'description',
            'tvdbdesc',
            'showtype',
            'showimage',
            'website',
            'imdb_id',
            'imdb_rating',
            'tomato_rating',
            'genre',
            'director',
            'actors',
            'awards',
            'internaltitle',
        ];

    public function getByTitle($title)
    {
        return $this->getRow('title', $title);
    }

    public function getByInternalTitle($title)
    {
        return $this->getRow('internaltitle', $title);
    }

    public function getByShortUrl($url)
    {
        return $this->getRow('shorturl', $url);
    }

    public function getByType($type)
    {
        $sql = <<<SQL

                SELECT *

                FROM showinfo

                WHERE showinfo.showtype = :type
                
                AND imdb_rating IS NOT NULL
                AND showimage IS NOT NULL

                ORDER BY showinfo.imdb_rating DESC;
SQL;

        return $this->db->query($sql, ['type'=>$type]);
    }

    public function getTodaySchedule($type){

        $sql = <<<SQL

                SELECT *

                FROM showinfo,programschedule

                WHERE showinfo.internaltitle = programschedule.title AND programschedule.program_date = CURDATE() AND showinfo.showtype = :type
                AND showimage IS NOT NULL AND starttime >= CURTIME()
                
                GROUP BY showinfo.internaltitle

                ORDER BY showinfo.imdb_rating DESC
                
                LIMIT 10;
SQL;

        return $this->db->query($sql, ['type'=>$type]);

    }
}