<?php

use Phinx\Migration\AbstractMigration;

class ProgramInfo extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $programSchedule = $this->table('programschedule');
        $programSchedule->removeColumn('programtype')
            ->removeColumn('imdb_id')
            ->removeColumn('episode_id')
            ->save();


        $programInfo = $this->table('programinfo');
        $programInfo
            ->addColumn('programid',        'string',       array('limit' => 255))
            ->addColumn('title',            'string',       array('limit' => 255))
            ->addColumn('description',      'text')
            ->addColumn('programimage',     'string',       array('limit' => 255, 'null' => true))
            ->addColumn('programtype',      'string',       array('limit' => 255, 'null' => true))
            ->addColumn('imdb_id',          'string',       array('limit' => 255, 'null' => true))
            ->addColumn('imdb_rating',      'float',       array('limit' => 255, 'null' => true))
            ->addColumn('season_id',        'string',       array('limit' => 255, 'null' => true))
            ->addColumn('episode_id',       'string',       array('limit' => 255, 'null' => true))
            ->addColumn('date_created',     'datetime')
            ->addColumn('date_updated',     'datetime',     array('null' => true))

            ->addIndex(array('programid'), array('unique' => true))
            ->addIndex(array('programtype',   'imdb_id', 'imdb_rating', 'season_id', 'episode_id'))
            ->save();
    }
}
