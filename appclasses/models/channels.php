<?php

class DBModel_Channels extends \Tohir\DBModel
{

    /**
     * @var string Name of Table
     */
    protected $tableName = 'channels';

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
            'channelid',
            'channelname',
            'channelnumber',
            'channeltag',
            'channellogo',
            'channelurl',
            'description',
            'genre_id',
            'active',
        ];

    public function getByChannelTag($tag)
    {
        return $this->getRow('channeltag', $tag);
    }
}