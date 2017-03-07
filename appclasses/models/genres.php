<?php

class DBModel_Genres extends \Tohir\DBModel
{

    /**
     * @var string Name of Table
     */
    protected $tableName = 'genres';

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

    protected $tableColumns = array(
            'genreid',
            'name',
            'canindex',
        );


    public function getIndexableGenres()
    {
        return $this->db->select($this->tableName, ['canindex'=>'Y']);
    }
}