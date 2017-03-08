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
        ];

    public function getByTitle($title)
    {
        return $this->getRow('title', $title);
    }
}