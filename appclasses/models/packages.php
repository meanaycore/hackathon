<?php

class DBModel_Packages extends \Tohir\DBModel
{

    /**
     * @var string Name of Table
     */
    protected $tableName = 'packages';

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
            'packageid',
            'title',
            'packagecode',
        );

    public function getPremiumCode()
    {
        $row = $this->getRow('packagecode', 'PRM');

        if (empty($row)) {
            return FALSE;
        } else {
            return $row['packageid'];
        }
    }
}