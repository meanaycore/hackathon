<?php

use Phinx\Migration\AbstractMigration;

class PackageGenreChannels extends AbstractMigration
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
        $packages = $this->table('packages');
        $packages
            ->addColumn('packageid',        'string',       array('limit' => 255))
            ->addColumn('title',            'string',       array('limit' => 255))
            ->addColumn('packagecode',      'string',       array('limit' => 20))
            ->addColumn('date_created',     'datetime')
            ->addColumn('date_updated',     'datetime',     array('null' => true))

            ->addIndex(array('packageid',   'packagecode'), array('unique' => true))
            ->save();

        $genres = $this->table('genres');
        $genres
            ->addColumn('genreid',          'string',       array('limit' => 255))
            ->addColumn('name',             'string',       array('limit' => 255))
            ->addColumn('canindex',         'string',       array('limit' => 1, 'default'=>'Y'))
            ->addColumn('date_created',     'datetime')
            ->addColumn('date_updated',     'datetime',     array('null' => true))

            ->addIndex(array('genreid'), array('unique' => true))
            ->save();

        $channels = $this->table('channels');
        $channels
            ->addColumn('channelid',        'string',       array('limit' => 255))
            ->addColumn('channelname',      'string',       array('limit' => 255))
            ->addColumn('channelnumber',    'string',       array('limit' => 5))
            ->addColumn('channeltag',       'string',       array('limit' => 20, 'null'=>true))
            ->addColumn('channellogo',      'string',       array('limit' => 255, 'null'=>true))
            ->addColumn('channelurl',       'string',       array('limit' => 255, 'null'=>true))
            ->addColumn('description',      'text')
            ->addColumn('genre_id',         'integer')
            ->addColumn('active',           'string',       array('limit' => 1, 'default'=>'Y'))
            ->addColumn('date_created',     'datetime')
            ->addColumn('date_updated',     'datetime',     array('null' => true))

            ->addIndex(array('channelid', 'channelnumber'), array('unique' => true))
            ->save();
    }
}
